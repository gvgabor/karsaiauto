<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\models\base\Ugyfelek;
use Throwable;
use Yii;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class UgyfelekAction extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Ugyfelek::find()->limit($this->pageSize)->offset(($this->page - 1) * $this->pageSize)->orderBy(["nev" => SORT_ASC]);

        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function save($formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];
        $model       = empty($formData["id"]) ? new Ugyfelek() : Ugyfelek::findOne($formData["id"]);
        $this->baseStatus($model);
        try {
            $result["success"] = true;
            $result["model"]   = $model;
            $model->setAttributes($formData);
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $transaction->commit();
            $result["success"] = true;
            $result["model"]   = $model;
            $result["message"] = Yii::t("app", "Ugyfel Mentese Sikeres", ["ugyfel" => $model->nev]);
        } catch (Throwable $exception) {
            Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result["errors"]  = $model->errors;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $this->errorStatus();
        }
        return $result;
    }

}
