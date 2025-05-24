<?php

namespace app\modules\autok\controllers;

use app\commands\ConsoleController;
use app\components\MainController;
use app\helpers\UtilHelper;
use app\models\base\AutokDokumentumok;
use app\modules\autok\actions\AutokAction;
use app\modules\autok\actions\DokumentumokDatasourceAction;
use app\modules\autok\models\AutokModel;
use Yii;
use yii\helpers\FileHelper;
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
            'dokumentumok-datasource' => [
                'class'   => DokumentumokDatasourceAction::class,
                'autokId' => $this->request->post('autokId'),
            ],
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
        $result                     = [];
        $result["total"]            = 0;
        $result["data"]             = [];
        return $result;
    }

    public function actionRemoveAuto()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model                      = AutokModel::findOne($this->request->post("id"));
        return [
            "success" => $model->softDelete()
        ];
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

        return $this->renderPartial("autok-form", ['model' => $model]);
    }

}
