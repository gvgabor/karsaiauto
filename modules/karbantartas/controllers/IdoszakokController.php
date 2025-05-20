<?php

namespace app\modules\karbantartas\controllers;

use app\components\MainController;
use app\models\base\Idoszakok;
use app\modules\karbantartas\actions\IdoszakokAction;
use Yii;
use yii\web\Response;

/**
 *
 */
class IdoszakokController extends MainController
{
    public function actions()
    {
        return [
            "idoszakok" => IdoszakokAction::class
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionIdoszakokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Idoszakok();
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $result                     = [];
            return Yii::$container->get(IdoszakokAction::class)->save($formData);
        }
        return $this->renderPartial("idoszakok-form", ['model' => $model]);
    }

}
