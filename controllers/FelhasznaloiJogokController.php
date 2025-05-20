<?php

namespace app\controllers;

use app\models\base\FelhasznaloiJogok;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FelhasznaloiJogokController extends ActiveController
{

    public $modelClass = 'app\\models\\base\\FelhasznaloiJogok';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            'text/html'        => Response::FORMAT_JSON,
        ];
        return $behaviors;
    }

    public function actionSave()
    {
        $result = [];
        $formData = $this->request->post("FelhasznaloiJogok");
        $model = empty($formData["id"]) ? new FelhasznaloiJogok() : FelhasznaloiJogok::findOne($formData["id"]);
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"] = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $result["errors"] = $model->errors;
            $transaction->rollBack();
        }

        return $result;
    }

    public function actionDelete($id)
    {
        $result = [];
        $model = FelhasznaloiJogok::findOne($id);
        if (empty($model)) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("Nincs ilyen model!");
        }
        try {
            if (count($model->felhasznalok)) {
                throw new BadRequestHttpException("Nem törölhető!");
            }
            $model->softDelete() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
        } catch (Throwable $exception) {
            Yii::$app->response->statusCode = 400;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $result["errors"] = $model->errors;
        }
        return $result;
    }

    public function actionIndex()
    {
        $query = FelhasznaloiJogok::find()->orderBy(["{{%felhasznaloi_jogok}}.id" => SORT_DESC]);

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

}