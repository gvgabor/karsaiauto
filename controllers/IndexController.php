<?php

namespace app\controllers;

use app\models\base\Felhasznalok;
use Exception;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

class IndexController extends Controller
{

    public $layout = "index";

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->homeUrl);
    }

    public function actionLogin()
    {
        $this->layout = "login";
        $model = new Felhasznalok();
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