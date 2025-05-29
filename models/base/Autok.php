<?php

namespace app\models\base;

use app\helpers\OptionsHelper;
use app\models\query\AutokQuery;
use yii\helpers\Html;

/**
 *
 * @property-read AutokImage[] $autokImage
 * @property-read AutokDokumentumok[] $autokDokumentumok
 * @property-read string $formatKilometer
 * @property-read string $motortipus
 * @property-read string $formatVetelar
 * @property-read AutokImage $firstImage
 * @property-read string $formatAkciosar
 * @property-read Ugyfelek $eladasUgyfel
 * @property-read string $valto
 * @property-read string $azonosito
 * @property-read string $tejlesitmenyText
 * @property-read mixed $hirdetesLeirasa
 * @property-read Markak $marka
 */
class Autok extends \app\models\Autok
{
    public static function find()
    {
        return new AutokQuery(get_called_class());
    }

    public function getFormatKilometer(): string
    {
        return number_format($this->kilometer, 0, "", " ");
    }

    public function getMarka()
    {
        return $this->hasOne(Markak::class, ['id' => 'marka_id']);
    }

    public function getMotortipus(): string
    {
        return OptionsHelper::motortipusOptions()[$this->motortipus_id];
    }

    public function getValto(): string
    {
        return OptionsHelper::valtoOptions()[$this->valto_id];
    }

    public function getAzonosito()
    {
        return sprintf("CR-%s", $this->longId);
    }

    public function getTejlesitmenyText(): string
    {
        return sprintf("%s KW (%s LE)", $this->teljesitmeny, $this->kwToLe(floatval($this->teljesitmeny)));
    }

    public function kwToLe(float $kw): float
    {
        return round($kw * 1.35962, 2);
    }

    public function getEladasUgyfel()
    {
        return $this->hasOne(Ugyfelek::class, ['id' => 'eladas_ugyfel_id']);
    }

    public function getFormatVetelar(): string
    {
        return number_format($this->vetelar, 0, "", " ");
    }

    public function getFormatAkciosar(): string
    {
        return number_format($this->akcios_ar ?? 0, 0, "", " ");
    }

    public function getFirstImage()
    {
        return $this->hasOne(AutokImage::class, ['autok_id' => 'id'])->orderBy(["{{%autok_image}}.sorrend" => SORT_ASC]);
    }

    public function getAutokImage()
    {
        return $this->hasMany(AutokImage::class, ['autok_id' => 'id'])->orderBy(["{{%autok_image}}.sorrend" => SORT_ASC]);
    }

    public function getAutokDokumentumok()
    {
        return $this->hasMany(AutokDokumentumok::class, ['autok_id' => 'id']);
    }

    public function getHirdetesLeirasa()
    {
        return nl2br(Html::encode($this->hirdetes_leirasa));
    }
}
