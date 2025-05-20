<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Markak;
use app\modules\karbantartas\actions\MarkakAction;
use Yii;
use yii\web\Response;

class MarkakController extends MainController
{
    public function actions()
    {
        return [
            'markak' => MarkakAction::class,
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionRemoveMarka()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Markak::findOne($this->request->post("id"));
        return $model->softDelete();
    }

    public function actionMarkakForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Markak();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(MarkakAction::class)->save($formData);
        }
        if ($id = $this->request->post("id")) {
            $model = Markak::findOne($id);
        }
        return $this->renderPartial("markak-form", ['model' => $model]);
    }

}
