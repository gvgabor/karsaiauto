<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\models\base\Autok;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class AutokAction extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Autok::find()->orderBy(["id" => SORT_DESC]);
        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function save(array $formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];
        $model       = empty($formData["id"]) ? new Autok() : Autok::findOne($formData["id"]);
        $this->baseStatus($model);
        try {
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"]   = $model;
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
