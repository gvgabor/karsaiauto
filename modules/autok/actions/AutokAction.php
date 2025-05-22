<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\models\base\Autok;
use app\models\base\AutokImage;
use Throwable;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class AutokAction extends MainAction
{
    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Autok::find()->orderBy(["id" => SORT_DESC]);
        return [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
    }

    public function save(array $formData)
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];
        $model       = empty($formData["id"]) ? new Autok() : Autok::findOne($formData["id"]);
        $this->baseStatus($model);
        try {
            $imageIdList = $model->getAutokImage()->select(["id"])->column();
            $model->setAttributes($formData);
            $model->image = UploadedFile::getInstances($model, "image");
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));

            $directory = Yii::getAlias("@webroot/uploads/autok/" . $model->longId);
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }
            $sorrend   = Json::decode($this->request->post("sorrend"));
            $oldImages = [];
            foreach ($sorrend as $item) {
                $current = ArrayHelper::getColumn($model->image, "name");
                $index   = array_search($item["name"], $current);
                if (!empty($item["id"])) {
                    $oldImages[] = ["id" => $item["id"], "sorrend" => $item["index"]];
                }
                if ($index !== false) {
                    $currentImage = $model->image[$index];
                    $name         = uniqid('auto-') . "." . $currentImage->getExtension();
                    $currentImage->saveAs($directory . DIRECTORY_SEPARATOR . $name);
                    $autokImage = new AutokImage([
                        "sorrend"  => $item["index"],
                        "autok_id" => $model->id,
                        "name"     => $name
                    ]);
                    $autokImage->save() ?: throw new BadRequestHttpException(Json::encode($autokImage->errors));
                }
            }

            foreach ($oldImages as $item) {
                $autokImage          = AutokImage::findOne($item['id']);
                $autokImage->sorrend = $item['sorrend'];
                $autokImage->save();
            }

            $difference = array_diff($imageIdList, ArrayHelper::getColumn($oldImages, "id"));

            foreach ($difference as $item) {
                $autokImage = AutokImage::findOne($item);
                $autokImage->softDelete();
            }

            $result["success"] = true;
            $result["model"]   = $model;
            $transaction->commit();
        } catch (Throwable $exception) {
            Yii::error($exception->getMessage());
            $transaction->rollBack();
            $result["errors"]  = $model->errors;
            $result["success"] = false;
            $result["message"] = $exception->getMessage();
            $this->errorStatus();
        }
        return $result;
    }

}
