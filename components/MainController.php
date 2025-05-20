<?php

namespace app\components;

use app\models\base\FelhasznaloiJogokMenu;
use app\models\base\Felhasznalok;
use app\models\base\Menu;
use Throwable;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Inflector;
use yii\web\BadRequestHttpException;
use yii\web\Controller;

abstract class MainController extends Controller
{
    public function createAction($id)
    {
        $id = Inflector::camel2words($id);
        $id = Inflector::slug($id);
        return parent::createAction($id);
    }

    public function removeModel(?MainActiveRecord $model)
    {
        try {
            if ($model === null) {
                throw new BadRequestHttpException("Nincs meg a model");
            }
            Yii::$app->response->statusCode = 200;
            return $model->softDelete();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            return $exception->getMessage();
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors["access"] = [
            'class'        => AccessControl::class,
            'denyCallback' => function () {
                Yii::$app->response->redirect([Yii::$app->homeUrl])->send();
            },
            'rules'        => [
                [
                    'allow'         => true,
                    'roles'         => ['@'],
                    'matchCallback' => function () {
                        $module = Yii::$app->controller->module->id;
                        $controller = Yii::$app->controller->id;
                        $url = $module . "/" . $controller;
                        $felhasznalo = Felhasznalok::findOne(Yii::$app->user->id);
                        $menu = Menu::find()->andWhere(["menu_url" => $url])->one();
                        $felhasznaloiJogokMenu = FelhasznaloiJogokMenu::find()->andWhere([
                            "felhasznaloi_jogok_id" => $felhasznalo->felhasznaloi_jog,
                            "menu_id"               => $menu->id
                        ])->one();
                        return $felhasznaloiJogokMenu !== null;
                    }
                ]
            ]
        ];
        return $behaviors;
    }
}