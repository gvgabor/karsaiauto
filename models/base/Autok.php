<?php

namespace app\models\base;

use app\models\query\AutokQuery;
use yii\web\UploadedFile;

/**
 *
 * @property-read Markak $marka
 */
class Autok extends \app\models\Autok
{
    /**
     * @var UploadedFile[]
     */
    public ?array $image = null;

    public static function find()
    {
        return new AutokQuery(get_called_class());
    }

    public function getMarka()
    {
        return $this->hasOne(Markak::class, ['id' => 'marka_id']);
    }

    public function fields()
    {
        $fields                   = parent::fields();
        $fields["marka"]          = fn () => $this->marka->name;
        $fields["vetelar_format"] = fn () => number_format($this->vetelar, 0, '', ' ') . ' Ft';
        return $fields;
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
                ],
                'required'
            ],
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 30],
        ]);
    }

    public function uploadImages()
    {

    }

}
