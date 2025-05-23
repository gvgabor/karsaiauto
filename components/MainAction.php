<?php

namespace app\components;

use Yii;
use yii\base\Action;
use yii\web\Application;
use yii\web\Request;

/**
 *
 * @property-read Request $request
 * @property-read array $adminColumns
 */
class MainAction extends Action
{
    public function getRequest(): ?Request
    {
        return Yii::$app instanceof Application ? Yii::$app->request : null;
    }

    public function baseStatus(MainActiveRecord $model)
    {
        if (Yii::$app instanceof Application) {
            Yii::$app->response->statusCode = $model->isNewRecord ? 201 : 202;
        }

    }

    public function errorStatus()
    {
        if (Yii::$app instanceof Application) {
            Yii::$app->response->statusCode = 400;
        }

    }

}
