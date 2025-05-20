<?php

namespace app\controllers;

use app\models\base\Felhasznalok;
use RuntimeException;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class FelhasznalokController extends ActiveController
{

    public $modelClass = 'app\\models\\base\\Felhasznalok';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionSave()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result = [];
        try {
            $formData = Yii::$app->request->post("Felhasznalok");
            if (empty($formData["id"])) {
                $model = new Felhasznalok();
                Yii::$app->response->statusCode = 201;
            } else {
                $model = Felhasznalok::findOne($formData["id"]);
                Yii::$app->response->statusCode = 200;
            }
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));

            $result["success"] = true;
            $result["model"] = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result["errors"] = $model->errors;
            $result["success"] = false;
            Yii::$app->response->statusCode = 422;
        }
        return $result;
    }

    public function actionJelszo()
    {
        $result = [];
        $formData = $this->request->post("Felhasznalok");
        if (empty($formData["id"])) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("id nem található!");
        }

        $model = Felhasznalok::findOne($formData['id']);
        if (empty($model)) {
            Yii::$app->response->statusCode = 400;
            throw new BadRequestHttpException("felhasználó nem található!");
        }

        $model->scenario = Felhasznalok::SCENARIO_JELSZO;

        try {
            $model->setAttributes($formData);
            $model->validate() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $model->jelszo = Yii::$app->security->generatePasswordHash($model->jelszo1);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
        } catch (Throwable $exception) {
            $result["success"] = false;
            Yii::$app->response->statusCode = 400;
            $result["errors"] = $model->errors;
            $result["message"] = $exception->getMessage();
        }

        return $result;
    }

    public function actionDelete($id)
    {
        $result = [];
        $model = Felhasznalok::findOne($id);
        if ($model->felhasznaloi_nev == "Vince") {
            throw new RuntimeException("Nem törölhető");
        }
        $result["success"] = $model->softDelete();
        return $result;
    }

    public function actionIndex()
    {
        $query = Felhasznalok::find()->orderById();

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
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

}