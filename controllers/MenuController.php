<?php

namespace app\controllers;

use app\models\base\FelhasznaloiJogokMenu;
use app\models\base\Menu;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class MenuController extends ActiveController
{
    public $modelClass = 'app\\models\\base\\Menu';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Menu::find()->orderBy(["{{%_menu}}.sorrend" => SORT_ASC]);

        $felhasznaloiJogId = $this->request->get("felhasznaloiJogId");

        if ($felhasznaloiJogId) {
            $menuIdList = FelhasznaloiJogokMenu::find()->menuIdList($felhasznaloiJogId);
            $query->andWhere(["id" => $menuIdList]);
        }

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function actionSaveHozzarendeles()
    {
        $result            = [];
        $felhasznaloiJogId = $this->request->post("felhasznaloiJogId");
        $menuIdList        = Json::decode($this->request->post("menuIdList"));
        $transaction       = Yii::$app->db->beginTransaction();
        try {
            FelhasznaloiJogokMenu::updateAll(["deleted" => 1], ["felhasznaloi_jogok_id" => $felhasznaloiJogId]);

            foreach ($menuIdList as $id) {
                $model = new FelhasznaloiJogokMenu([
                    "menu_id"               => $id,
                    "felhasznaloi_jogok_id" => $felhasznaloiJogId
                ]);
                $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            }

            $result["success"] = true;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $result["success"]              = false;
            $result["message"]              = $exception->getMessage();
            $transaction->rollBack();
        }

        return $result;
    }

    public function actionDelete($id)
    {
        $result = [];
        $model  = Menu::findOne($id);

        if (empty($model)) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("Nincs ilyen model!");
        }

        if ($model->hasChild) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("Nem lehet törölni!");
        }

        $result["success"] = $model->softDelete();

        return $result;
    }

    public function actionSave()
    {
        $result   = [];
        $formData = $this->request->post("Menu");
        $model    = empty($formData["id"]) ? new Menu() : Menu::findOne($formData["id"]);

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"]   = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $transaction->rollBack();
            $result["success"] = false;
            $result["errors"]  = $model->errors;
            $result["message"] = $exception->getMessage();
        }

        return $result;
    }

    public function behaviors()
    {
        $behaviors                                 = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            'text/html'        => Response::FORMAT_JSON,
        ];
        return $behaviors;
    }
}
