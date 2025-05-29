<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Felszereltseg;
use app\models\base\Szinek;
use app\modules\karbantartas\actions\FelszereltsegAction;
use app\modules\karbantartas\actions\SzinekAction;
use Yii;
use yii\web\Response;

class SzinekController extends MainController
{
    public function actions()
    {
        return [
            'szinek' => SzinekAction::class
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }



    public function actionSzinekForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Szinek();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(SzinekAction::class)->save($formData);
        }
        if ($id = $this->request->post("id")) {
            $model = Szinek::findOne($id);
        }
        return $this->renderPartial("szinek-form", ['model' => $model]);
    }

    public function actionRemoveSzinek()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Szinek::findOne($this->request->post("id"));
        return $model->softDelete()->deleteMessage($model->szin_neve);
    }
}
