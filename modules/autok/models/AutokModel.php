<?php

namespace app\modules\autok\models;

use app\components\behaviors\NumericSanitizeBehavior;
use app\models\base\Autok;
use DateTime;
use Throwable;
use Yii;
use yii\web\UploadedFile;

/**
 *
 *
 */
final class AutokModel extends Autok
{
    /**
     * @var UploadedFile[]
     */
    public ?array $image = null;

    /**
     * @var UploadedFile[]
     */
    public ?array $dokumentumok = null;

    public ?array $felszereltseg = null;

    public function fields()
    {
        $fields                       = parent::fields();
        $fields["marka"]              = fn () => $this->marka->name;
        $fields["vetelar_format"]     = fn () => number_format($this->vetelar, 0, '', ' ') . ' Ft';
        $fields['kepek_szama']        = fn () => count($this->autokImage);
        $fields['dokumentumok_szama'] = fn () => count($this->autokDokumentumok);
        $fields['fooldalra']          = fn () => $this->fooldalra ? "IGEN" : "NEM";
        $fields['akcios']             = fn () => $this->akcios ? "IGEN" : "NEM";
        $fields['eladva']             = fn () => $this->eladva ? "IGEN" : "NEM";
        $fields['eladva_int']         = fn () => $this->eladva;
        $fields['publikalva']         = fn () => $this->publikalva ? "IGEN" : "NEM";
        $fields["edit_text"]          = fn () => Yii::t("app", "edit_text", ["name" => $this->hirdetes_cime]);
        $fields["delete_text"]        = fn () => Yii::t("app", "delete_text", ["name" => $this->hirdetes_cime]);
        $fields["confirm_text"]       = fn () => Yii::t("app", "confirm_text", ["name" => $this->hirdetes_cime]);
        $fields["azonosito"]          = fn () => $this->azonosito;
        $fields["hirdetes_leirasa"]   = fn () => $this->hirdetesLeirasa;
        $fields["edit"]               = function () {
            $edit        = 0;
            $currentDate = new DateTime();
            $currentDate->modify("-1 hour");
            if (!empty($this->updated_at) && $this->updated_at > $currentDate->format("Y-m-d H:i:s")) {
                $edit = 1;
            }
            return $edit;
        };
        return $fields;
    }

    public function behaviors()
    {
        $behaviors                    = parent::behaviors();
        $behaviors["numericSanitize"] = [
            "class"      => NumericSanitizeBehavior::class,
            'attributes' => [
                'kilometer',
                'vetelar',
                'gyartasi_ev',
                'akcios_ar',
                'teljesitmeny',
            ],
        ];
        return $behaviors;
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [
                [
                    'jarmutipus_id',
                    'marka_id',
                    'model',
                    'gyartasi_ev',
                    'kilometer',
                    'vetelar',
                    'hirdetes_cime',
                    'motortipus_id',
                    'valto_id'
                ],
                'required'
            ],
            [
                [
                    'felszereltseg'
                ],
                'safe'
            ],
            [
                ['image'],
                'file',
                'extensions' => 'png, jpg, jpeg, webp',
                'mimeTypes'  => 'image/jpeg, image/png, image/webp',
                'maxFiles'   => 30
            ],
            [
                ['dokumentumok'],
                'file',
                'maxFiles' => 30
            ],
            [
                ['akcios_ar'],
                'required',
                'when' => function () {
                    return !empty($this->akcios);
                }
            ]
        ]);
    }

    public function softDelete()
    {
        foreach ($this->autokImage as $model) {
            try {
                if (empty($model->remote_key)) {
                    unlink($model->imagePath);
                } else {
                    Yii::$app->r2->delete($model->remote_key);
                }
            } catch (Throwable $exception) {
                Yii::error("Hiba a kép törlése közben: " . $exception->getMessage());
            }
        }

        foreach ($this->autokDokumentumok as $model) {
            try {
                unlink($model->path);
            } catch (Throwable $exception) {
                Yii::error("Hiba a kép törlése közben: " . $exception->getMessage());
            }
        }

        return parent::softDelete();
    }
}
