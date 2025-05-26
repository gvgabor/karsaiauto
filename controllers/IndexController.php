<?php

namespace app\controllers;

use app\components\enums\LandingDataSourceType;
use app\controllers\actions\LandingDatasourceAction;
use app\models\base\Felhasznalok;
use Exception;
use Throwable;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class IndexController extends Controller
{
    public $layout = "index";

    public function createAction($id)
    {
        $id = Inflector::camel2words($id);
        $id = Inflector::slug($id);
        return parent::createAction($id);
    }

    public function actions()
    {
        return [
            'akcios-datasource' => [
                'class' => LandingDatasourceAction::class,
                'type'  => $this->request->post('type', LandingDataSourceType::AKCIOS->value),
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->homeUrl);
    }

    public function actionChangeLanguage()
    {
        if ($lang = Yii::$app->request->get('lang')) {
            Yii::$app->language = $lang;
            Yii::$app->session->set('language', $lang);
        } elseif (Yii::$app->session->has('language')) {
            Yii::$app->language = Yii::$app->session->get('language');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogin()
    {
        $this->layout = "login";
        $model        = new Felhasznalok();
        $model->setScenario(Felhasznalok::SCENARIO_LOGIN);

        if ($formData = $this->request->post("Felhasznalok")) {
            try {
                $model->setAttributes($formData);
                $model->validate() ?: throw new BadRequestHttpException(Json::encode($model->errors));

                $user = Felhasznalok::findOne([
                    'felhasznaloi_nev' => $model->felhasznaloi_nev,
                    'deleted'          => 0,
                ]);

                $user?->setScenario(Felhasznalok::SCENARIO_LOGIN);
                if (!$user || !$user->validatePassword($model->jelszo)) {
                    $model->addError("jelszo", "Hibás jelszó vagy felhasználónév!");
                    return $this->render("login", ['model' => $model]);
                }

                if (!Yii::$app->user->login($user)) {
                    throw new Exception('Beléptetés sikertelen.');
                }

                return $this->redirect(['/admin']); // Ezt javítottuk
            } catch (Throwable $exception) {
                Yii::error($exception->getMessage(), 'login');
                $model->addError('jelszo', 'Technikai hiba: ' . $exception->getMessage());
            }
        }

        return $this->render("login", ['model' => $model]);
    }

}
