<?php

namespace app\models\base;

use app\models\query\AutokQuery;
use yii\web\UploadedFile;

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

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['image'], 'file', 'extensions' => 'png, jpg, jpeg, webp', 'maxFiles' => 30],
        ]);
    }

    public function uploadImages()
    {

    }

}
