<?php

namespace app\modules\autok\controllers;

use app\commands\ConsoleController;
use app\components\MainController;
use app\helpers\UtilHelper;
use app\models\base\AutokDokumentumok;
use app\modules\autok\actions\AutokAction;
use app\modules\autok\actions\DokumentumokDatasourceAction;
use app\modules\autok\actions\UgyfelekAction;
use app\modules\autok\models\AutokModel;
use app\modules\autok\models\EladasModel;
use Yii;
use yii\helpers\FileHelper;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class IndexController extends MainController
{
    public function actions()
    {
        return [
            'autok' => [
                'class'              => AutokAction::class,
                'page'               => $this->request->post('page', 1),
                'pageSize'           => $this->request->post('pageSize', 1),
                'filters'            => $this->request->post('filter'),
                'gridFilterSelector' => $this->request->post('gridFilterSelector'),
            ],
            'dokumentumok-datasource' => [
                'class'   => DokumentumokDatasourceAction::class,
                'autokId' => $this->request->post('autokId'),
            ],
            'ugyfelek' => [
                "class"    => UgyfelekAction::class,
                "pageSize" => $this->request->post("pageSize", 1),
                "page"     => $this->request->post("page", 1),
                "filters"  => $this->request->post("filter")
            ]
        ];
    }

    public function actionIndex()
    {

        return $this->render("index");
    }

    public function actionDokumentumok()
    {
        $autokDokumentumok = AutokDokumentumok::findOne($this->request->get("id"));
        $mime              = FileHelper::getMimeType($autokDokumentumok->path);
        $filename          = $autokDokumentumok->name . "." . $autokDokumentumok->extension;
        return $this->response->sendFile($autokDokumentumok->path, $filename, [
            "inline"   => true,
            "mimeType" => $mime,
        ]);
    }

    public function actionEladvaForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = EladasModel::findOne($this->request->post("id")) ?? new EladasModel();

        if ($model->eladva) {
            throw new ForbiddenHttpException("El lett már adva");
        }

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(AutokAction::class)->eladas($formData);
        }

        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomEladasModel($model->id);
        }

        return $this->renderPartial("eladva-form", ['model' => $model]);
    }

    public function actionRemoveAuto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = AutokModel::findOne($this->request->post("id"));
        if ($model->eladva) {
            throw new ForbiddenHttpException("El lett már adva");
        }
        return [
            "success" => $model->softDelete()
        ];
    }

    public function actionDetail()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = AutokModel::findOne($this->request->post("id"));
        return $this->renderPartial("detail", ['model' => $model]);
    }

    public function actionAutokForm()
    {
        Yii::$app->response->format = Response::FORMAT_HTML;
        $model                      = new AutokModel();
        if (UtilHelper::isLocal()) {
            $model = Yii::$container->get(ConsoleController::class)->actionRandomAuto();
        }

        if ($formData = $this->request->post($model->shortname)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$container->get(AutokAction::class)->save($formData);
        }

        if ($id = $this->request->post("id")) {
            $model = AutokModel::findOne($id);
        }

        if ($model->eladva) {
            throw new ForbiddenHttpException("El lett már adva");
        }

        return $this->renderPartial("autok-form", ['model' => $model]);
    }

}
