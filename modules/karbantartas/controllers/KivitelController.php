<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Kivitel;
use app\modules\karbantartas\actions\KivitelAction;
use Yii;
use yii\web\Response;

class KivitelController extends MainController
{
    public function actions()
    {
        return [
            'kivitel' => KivitelAction::class
        ];
    }

    public function actionRemoveKivitel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Kivitel::findOne($this->request->post("id"));
        return $model->softDelete()->deleteMessage($model->name);
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionKivitelForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Kivitel();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(KivitelAction::class)->save($formData);
        }
        if ($id = $this->request->post("id")) {
            $model = Kivitel::findOne($id);
        }
        return $this->renderPartial("kivitel-form", ['model' => $model]);
    }

}
