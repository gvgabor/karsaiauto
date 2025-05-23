<?php

namespace app\models\base;

use app\models\query\AutokImageQuery;
use Yii;
use yii\helpers\Url;

/**
 *
 *
 * @property-read Autok $autok
 */
class AutokImage extends \app\models\AutokImage
{
    public static function find()
    {
        return new AutokImageQuery(get_called_class());
    }

    public function fields()
    {
        $fields          = parent::fields();
        $fields["image"] = fn () => $this->name;
        return $fields;
    }

    public function getAutok()
    {
        return $this->hasOne(Autok::class, ['id' => 'autok_id']);
    }

}
