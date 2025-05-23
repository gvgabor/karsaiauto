<?php

namespace app\modules\autok\controllers;

use app\commands\ConsoleController;
use app\components\MainController;
use app\helpers\UtilHelper;
use app\models\base\Autok;
use app\modules\autok\actions\AutokAction;
use Yii;
use yii\web\Response;

class IndexController extends MainController
{
    public function actions()
    {
        return [
            'autok' => [
                'class'    => AutokAction::class,
                'page'     => $this->request->post('page', 1),
                'pageSize' => $this->request->post('pageSize', 1),
                'filters'  => $this->request->post('filter')
            ],
        ];
    }

    public function actionIndex()
    {

        return $this->render("index");
    }

    public function actionRemoveAuto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = Autok::findOne($this->request->post("id"));
        return [
            "success" => $model->softDelete()
        ];
    }

    public function actionAutokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new Autok();
        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomAuto();
        }

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(AutokAction::class)->save($formData);
        }

        if ($id = $this->request->post("id")) {
            $model = Autok::findOne($id);
        }

        return $this->renderPartial("autok-form", ['model' => $model]);
    }

}
