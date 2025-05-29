<?php

namespace app\modules\karbantartas\actions;

use app\components\MainAction;
use app\models\base\Felszereltseg;
use app\models\base\Kivitel;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class KivitelAction extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $result                     = [];

        $query           = Kivitel::find()->orderBy(['name' => SORT_ASC]);
        $result['total'] = $query->count();
        $result['data']  = $query->all();

        return $result;
    }

    public function save($formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];
        $model       = empty($formData["id"]) ? new Kivitel() : Kivitel::findOne($formData["id"]);
        $this->baseStatus($model);
        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"]   = $model;
            $result["message"] = Yii::t("app", "Mentes Sikeres");
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result["errors"]  = $model->errors;
            $result["success"] = false;
            $this->errorStatus();
        }
        return $result;
    }
}
