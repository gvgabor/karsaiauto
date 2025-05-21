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
        $fields["image"] = function () {
            $path = Yii::getAlias("@webroot/uploads/autok/" . $this->autok->longId . "/" . $this->name);
            $url  = is_file($path) ? Url::to("@web/uploads/autok/" . $this->autok->longId . "/" . $this->name) : "https://placehold.co/200x160";
            return $url;
        };
        return $fields;
    }

    public function getAutok()
    {
        return $this->hasOne(Autok::class, ['id' => 'autok_id']);
    }

}
