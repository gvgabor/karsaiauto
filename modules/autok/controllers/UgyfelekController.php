<?php

namespace app\modules\autok\controllers;

use app\commands\ConsoleController;
use app\components\MainController;
use app\helpers\UtilHelper;
use app\models\base\Ugyfelek;
use app\modules\autok\actions\UgyfelekAction;
use Yii;
use yii\web\Response;

class UgyfelekController extends MainController
{
    public function actions()
    {
        return [
            'ugyfelek' => [
                "class"    => UgyfelekAction::class,
                "pageSize" => $this->request->post("pageSize", 1),
                "page"     => $this->request->post("page", 1),
            ]
        ];
    }

    public function actionIndex()
    {
        return $this->render("index");
    }

    public function actionRemoveUgyfel()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Ugyfelek::findOne(intval($this->request->post("id")));
        return $model->softDelete()->deleteMessage($model->nev);
    }

    public function actionUgyfelekForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Ugyfelek();
        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomUgyfel();
        }
        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(UgyfelekAction::class)->save($formData);
        }

        if ($id = $this->request->post("id")) {
            $model = Ugyfelek::findOne($id);
        }
        return $this->renderPartial("ugyfelek-form", ['model' => $model]);
    }

}
