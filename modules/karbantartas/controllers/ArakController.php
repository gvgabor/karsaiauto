<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Arvalaszto;
use app\modules\karbantartas\actions\ArvalasztoAction;
use Yii;
use yii\web\Response;

class ArakController extends MainController
{
    public function actions()
    {
        return [
            'arvalaszto' => ArvalasztoAction::class
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionArvalasztoForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Arvalaszto();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(ArvalasztoAction::class)->save($formData);
        }
        return $this->renderPartial("arvalaszto-form", ['model' => $model]);
    }

}
