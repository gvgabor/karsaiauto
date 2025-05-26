<?php

namespace app\modules\autok\actions;

use app\components\MainAction;
use app\helpers\R2Helper;
use app\models\base\AutokDokumentumok;
use app\models\base\AutokImage;
use app\modules\autok\models\AutokModel;
use app\modules\autok\models\EladasModel;
use SplFileInfo;
use Throwable;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\BadRequestHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class AutokAction extends MainAction
{
    public ?int $gridFilterSelector = null;
    protected array $_filters       = [];

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = AutokModel::find()
            ->joinWith(["marka"])
            ->with(["autokImage", "autokDokumentumok"])
            ->orderBy(["id" => SORT_DESC])
            ->limit($this->pageSize)
            ->offset(($this->page - 1) * $this->pageSize);

        if (!empty($this->gridFilterSelector)) {
            if ($this->gridFilterSelector == 1) {
                $query->andFilterWhere(['eladva' => 1]);
            }
            if ($this->gridFilterSelector == 2) {
                $query->andFilterWhere(['eladva' => 0]);
            }
        }

        foreach ($this->filters as $item) {
            switch ($item["field"]) {
                case "hirdetes_cime":
                    $query->andFilterWhere(['like', 'hirdetes_cime', trim($item['value'])]);
                    break;
                case "marka":
                    $query->andFilterWhere(['like', 'markak.name', trim($item['value'])]);
                    break;
                case "model":
                    $query->andFilterWhere(['like', 'model', trim($item['value'])]);
                    break;
                case "eladva":
                    $query->andFilterWhere(['=', 'eladva', boolval($item["value"])]);
                    break;
                case "publikalva":
                    $query->andFilterWhere(['=', 'publikalva', boolval($item["value"])]);
                    break;
                case "akcios":
                    $query->andFilterWhere(['=', 'akcios', boolval($item["value"])]);
                    break;
                case "fooldalra":
                    $query->andFilterWhere(['=', 'fooldalra', boolval($item["value"])]);
                    break;
            }
        }

        $result = [
            "total" => $query->count(),
            "data"  => $query->all(),
        ];
        return $result;
    }

    public function eladas($formData): array
    {
        $result      = [];
        $transaction = Yii::$app->db->beginTransaction();
        $model       = empty($formData["id"]) ? new EladasModel() : EladasModel::findOne($formData["id"]);
        $this->baseStatus($model);
        try {
            $model->setAttributes($formData);
            $model->eladva = 1;
            $model->save() ?: throw new BadRequestHttpException(Json::encode($model->errors));
            $result["success"] = true;
            $result["model"]   = AutokModel::findOne($model->id);
            $result["message"] = Yii::t("app", "Eladasa sikeres", ["auto" => $model->hirdetes_cime]);
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

    public function save(array $formData, $images = [])
    {
        $transaction = Yii::$app->db->beginTransaction();
        $result      = [];
        $model       = empty($formData["id"]) ? new AutokModel() : AutokModel::findOne($formData["id"]);
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
                        $source      = $directory . DIRECTORY_SEPARATOR . $name;
                        $destination = $directory . DIRECTORY_SEPARATOR . $name . ".webp";
                        $this->convertToWebP($source, $destination);
                        unlink($source);

                        $autokImage = new AutokImage([
                            "sorrend"  => $item["index"],
                            "autok_id" => $model->id,
                            "name"     => Url::to(["@web/uploads/autok/" . $model->longId . "/" . $name . ".webp",], true)
                        ]);

                        $sourcePath = $directory . DIRECTORY_SEPARATOR . $name . ".webp";

                        try {
                            Yii::$app->r2->upload($sourcePath, "autok/" . $name . ".webp");
                            $url                    = R2Helper::getUrl($name . ".webp");
                            $autokImage->name       = $name;
                            $autokImage->url        = $url;
                            $autokImage->remote_key = "autok/" . $name . ".webp";
                            unlink($sourcePath);
                        } catch (Throwable $exception) {
                            Yii::error("Sikertelen feltöltés: " . $exception->getMessage());
                        }

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

                    if (empty($autokImage->remote_key)) {
                        unlink($autokImage->imagePath);
                    } else {
                        Yii::$app->r2->delete($autokImage->remote_key);
                    }

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

            $path = Yii::getAlias("@app/dokumentumok/" . $model->longId);
            FileHelper::createDirectory($path);

            if (Yii::$app instanceof Application) {
                $dokumentumok      = Json::decode($this->request->post("dokumentumok"));
                $dokumentumokFiles = UploadedFile::getInstancesByName("dokumetumokFiles");

                $oldDokumentumok     = ArrayHelper::getColumn($model->autokDokumentumok, "id");
                $currentDokumentumok = ArrayHelper::getColumn(array_filter($dokumentumok, fn ($item) => !empty($item["id"])), "id");
                $difference          = array_diff($oldDokumentumok, $currentDokumentumok);

                foreach ($dokumentumok as $item) {
                    if (!empty($item["id"])) {
                        $autokDokumentumok       = AutokDokumentumok::findOne($item["id"]);
                        $autokDokumentumok->name = $item["name"];
                        $autokDokumentumok->save();
                    }
                }

                foreach ($difference as $item) {
                    $autokDokumentumok = AutokDokumentumok::findOne($item);
                    $autokDokumentumok->softDelete();
                }

                foreach ($dokumentumokFiles as $item) {
                    $name              = $item->name;
                    $index             = array_search($name, ArrayHelper::getColumn($dokumentumok, "uploadName"));
                    $current           = $dokumentumok[$index];
                    $uniquename        = uniqid("doc-") . "." . $item->getExtension();
                    $autokDokumentumok = new AutokDokumentumok([
                        "name"      => $current["name"],
                        "extension" => $current["extension"],
                        "filename"  => $uniquename,
                        "autok_id"  => $model->id,
                    ]);
                    $item->saveAs($path . DIRECTORY_SEPARATOR . $uniquename);
                    $autokDokumentumok->save() ?: throw new BadRequestHttpException(Json::encode($autokDokumentumok->errors));
                }
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

    public function convertToWebP(string $sourcePath, string $destinationPath, int $quality = 80): bool
    {
        $info = getimagesize($sourcePath);
        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($sourcePath);
                // transzparencia támogatás
                imagepalettetotruecolor($image);
                imagealphablending($image, true);
                imagesavealpha($image, true);
                break;
            default:
                return false; // nem támogatott formátum
        }

        // WebP mentés
        $result = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);
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

        if (array_key_exists("filters", $filters) === false) {
            $this->_filters = [];
        } else {
            $this->_filters = $filters['filters'];
        }
    }

}
