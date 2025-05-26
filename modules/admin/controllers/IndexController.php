<?php

namespace app\modules\admin\controllers;

use app\commands\ConsoleController;
use app\components\MainController;
use app\helpers\UtilHelper;
use app\models\base\FelhasznaloiJogok;
use app\models\base\Felhasznalok;
use app\models\base\Menu;
use app\modules\admin\actions\FelhasznaloiJogokAction;
use app\modules\admin\actions\FelhasznalokAction;
use app\modules\admin\actions\MenuAction;
use Yii;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class IndexController extends MainController
{
    public function actions()
    {
        return [
            "felhasznalok"       => FelhasznalokAction::class,
            "felhasznaloi-jogok" => FelhasznaloiJogokAction::class,
            "menu"               => [
                "class"             => MenuAction::class,
                "felhasznaloiJogId" => intval($this->request->post("felhasznaloiJogId"))
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFelhasznalokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Felhasznalok();

        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomFelhasznalo();
        }

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(FelhasznalokAction::class)->save($formData);
        }

        if ($id = $this->request->post("id")) {
            $model = Felhasznalok::findOne($id);
            if ($model->felhasznaloi_jog == $_ENV['SUPERADMIN_ID']) {
                if (Yii::$app->user->can("rootmanage") === false) {
                    throw new ForbiddenHttpException("Jogosultság hiányzik");
                }
            }
        }

        return $this->renderPartial('felhasznalok-form', ['model' => $model]);
    }

    public function actionHozzarendelesForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        if ($this->request->post("action")) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $menuIdList                 = Json::decode($this->request->post("menuIdList"));
            return Yii::$container->get(FelhasznaloiJogokAction::class)->hozzarendeles($this->request->post("felhasznaloiJogId"), $menuIdList);
        }

        if ($id = $this->request->post("id")) {
            if ($id == $_ENV['SUPERADMIN_ID']) {
                if (Yii::$app->user->can("rootmanage") === false) {
                    throw new ForbiddenHttpException("Jogosultság hiányzik");
                }
            }
        }

        return $this->renderPartial('hozzarendeles-form');
    }

    public function actionRemoveFelhasznalo($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Felhasznalok::findOne($id);
        if ($model->felhasznaloi_jog == $_ENV['SUPERADMIN_ID']) {
            throw new ForbiddenHttpException("Jogosultság hiányzik");
        }
        return $this->removeModel($model);
    }

    public function actionRemoveFelhasznaloiJogok($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = FelhasznaloiJogok::findOne($id);

        if ($model->id == $_ENV['SUPERADMIN_ID']) {
            throw new ForbiddenHttpException("Jogosultság hiányzik");
        }

        $auth = Yii::$app->authManager;
        $role = $auth->getRole(Inflector::slug($model->jogosultsag_neve, "_"));

        if ($role) {
            $auth->removeChildren($role);
            $auth->remove($role);
        }

        return $this->removeModel($model);
    }

    public function actionRemoveMenu($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Menu::findOne($id);
        if ($model->hasChild) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("Nem lehet törölni!");
        }
        return $this->removeModel($model);
    }

    public function actionMenuForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Menu();

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(MenuAction::class)->save($formData);
        }

        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomMenu();
        }

        if ($id = $this->request->post("id")) {
            $model = Menu::findOne($id);
        }
        return $this->renderPartial('menu-form', ['model' => $model]);
    }

    public function actionFelhasznaloiJogokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new FelhasznaloiJogok();

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(FelhasznaloiJogokAction::class)->save($formData);
        }

        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomFelhasznaloiJog();
        }

        if ($id = $this->request->post("id")) {
            $model = FelhasznaloiJogok::findOne($id);
            if ($model->id == $_ENV['SUPERADMIN_ID']) {
                if (Yii::$app->user->can("rootmanage") === false) {
                    throw new ForbiddenHttpException("Jogosultság hiányzik");
                }

            }
        }
        return $this->renderPartial('felhasznaloi-jogok-form', ['model' => $model]);
    }

    public function actionJelszoValtoztatasForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = Felhasznalok::findOne($this->request->post("id")) ?? new Felhasznalok();
        $model->scenario            = Felhasznalok::SCENARIO_JELSZO;

        if ($model->felhasznaloi_jog == $_ENV['SUPERADMIN_ID']) {
            if (Yii::$app->user->can("rootmanage") === false) {
                throw new ForbiddenHttpException("Jogosultság hiányzik");
            }
        }

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(FelhasznalokAction::class)->jelszo($formData);
        }

        if (empty($model)) {
            Yii::$app->response->statusCode = 401;
            throw new BadRequestHttpException("Nincs meg a felhasználó");
        }
        return $this->renderPartial('valtoztatas-form', ['model' => $model]);
    }

}
