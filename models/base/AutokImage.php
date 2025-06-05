<?php

namespace app\models\base;

use app\models\query\AutokImageQuery;
use Yii;
use yii\helpers\Url;

/**
 *
 *
 * @property-read mixed $imagePath
 * @property-read string $imageUrl
 * @property-read Autok $autok
 */
class AutokImage extends \app\models\AutokImage
{
    public static function find()
    {
        return new AutokImageQuery(get_called_class());
    }

    public function getImagePath()
    {
        $path = Yii::getAlias("@app/web/uploads/autok/" . $this->autok->longId . DIRECTORY_SEPARATOR . $this->name);
        return $path;
    }

    public function getImageUrl(): string
    {
        $url = "https://placehold.co/200x160";
        if (empty($this->remote_key)) {
            $path = $this->imagePath;
            if (is_file($path)) {
                $url = Url::to(["@web/uploads/autok/" . $this->autok->longId . "/" . $this->name], true);
            }
        } else {
            $url = $this->url;
        }
        return $url;
    }

    public function fields()
    {
        $fields          = parent::fields();
        $fields["image"] = fn () => $this->imageUrl;
        return $fields;
    }

    public function getAutok()
    {
        return $this->hasOne(Autok::class, ['id' => 'autok_id']);
    }

}
