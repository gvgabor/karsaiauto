<?php

namespace app\components;

use Yii;
use yii\base\Action;
use yii\web\Request;

/**
 *
 * @property-read Request $request
 * @property-read array $adminColumns
 */
class MainAction extends Action
{

    public function getRequest(): Request
    {
        return Yii::$app->request;
    }

    public function baseStatus(MainActiveRecord $model)
    {
        Yii::$app->response->statusCode = $model->isNewRecord ? 201 : 202;
    }

    public function errorStatus()
    {
        Yii::$app->response->statusCode = 400;
    }

}