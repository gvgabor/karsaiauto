<?php

namespace app\models\base;

use app\models\query\AutokQuery;

/**
 *
 * @property-read AutokImage[] $autokImage
 * @property-read AutokDokumentumok[] $autokDokumentumok
 * @property-read Markak $marka
 */
class Autok extends \app\models\Autok
{
    public static function find()
    {
        return new AutokQuery(get_called_class());
    }

    public function getMarka()
    {
        return $this->hasOne(Markak::class, ['id' => 'marka_id']);
    }

    public function getAutokImage()
    {
        return $this->hasMany(AutokImage::class, ['autok_id' => 'id'])->orderBy(["{{%autok_image}}.sorrend" => SORT_ASC]);
    }

    public function getAutokDokumentumok()
    {
        return $this->hasMany(AutokDokumentumok::class, ['autok_id' => 'id']);
    }
}
