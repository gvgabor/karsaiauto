<?php

namespace app\modules\autok\controllers;

use app\components\MainController;
use app\models\base\Autok;
use Yii;
use yii\web\Response;

class IndexController extends MainController
{
    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionAutokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Autok();
        return $this->renderPartial("autok-form", ['model' => $model]);
    }

}
