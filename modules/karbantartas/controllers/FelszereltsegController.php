<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Felszereltseg;
use app\modules\karbantartas\actions\FelszereltsegAction;
use Yii;
use yii\web\Response;

class FelszereltsegController extends MainController
{
    public function actions()
    {
        return [
            'felszereltseg' => FelszereltsegAction::class
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionRemoveFelszereltseg()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Felszereltseg::findOne($this->request->post("id"));
        return $model->softDelete()->deleteMessage($model->name);
    }

    public function actionFelszereltsegForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Felszereltseg();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(FelszereltsegAction::class)->save($formData);
        }
        if ($id = $this->request->post("id")) {
            $model = Felszereltseg::findOne($id);
        }
        return $this->renderPartial("felszereltseg-form", ['model' => $model]);
    }

}
