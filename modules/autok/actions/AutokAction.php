<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\models\base\Autok;
use app\models\base\AutokImage;
use SplFileInfo;
use Throwable;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\web\Application;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 *
 *
 * @property array $filters
 */
class AutokAction extends MainAction
{
    public int $pageSize = 1;
    public int $page     = 1;

    protected array $_filters = [];

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = Autok::find()
            ->with("autokImage")
            ->orderBy(["id" => SORT_DESC])
            ->limit($this->pageSize)
            ->offset(($this->page - 1) * $this->pageSize);


        $result = [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
        return $result;
    }

    public function save(array $formData, $images = [])
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

            if (Yii::$app instanceof Application) {
                $directory = Yii::getAlias("@webroot/uploads/autok/" . $model->longId);
            } else {
                $directory = Yii::getAlias("@app/web/uploads/autok/" . $model->longId);
            }

            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            if (count($images) === 0) {
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
            }

            $counter = 1;
            foreach ($images as $item) {
                $info = new SplFileInfo($item);
                $name = uniqid('auto-') . "." . $info->getExtension();
                copy($item, $directory . DIRECTORY_SEPARATOR . $name);
                $autokImage = new AutokImage([
                    "sorrend"  => $counter++,
                    "autok_id" => $model->id,
                    "name"     => $name
                ]);
                $autokImage->save() ?: throw new BadRequestHttpException(Json::encode($autokImage->errors));
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

    /**
     * @return array
     */
    public function getFilters()
    {
        return $this->_filters;
    }

    /**
     * @param array $filters
     */
    public function setFilters($filters)
    {
        if (is_array($filters) === false) {
            $filters = [];
        }
        $filters        = array_key_exists("filters", $filters) === false ? [] : $filters["filters"];
        $this->_filters = $filters;
    }

}
