<?php

namespace app\helpers;

use app\models\base\Arvalaszto;
use app\models\base\FelhasznaloiJogok;
use app\models\base\Idoszakok;
use app\models\base\Markak;
use app\models\base\Ugyfelek;
use Yii;
use yii\helpers\ArrayHelper;

class OptionsHelper
{
    public static function felhasznaloiJogokOptions(): array
    {
        return ArrayHelper::map(FelhasznaloiJogok::find()->all(), "id", "jogneve");
    }

    public static function markakOptions(): array
    {
        return ArrayHelper::map(Markak::find()->all(), "id", "name");
    }

    public static function jarmutipusaOptions(): array
    {
        return [
            1 => Yii::t("app", "Kisteherautó"),
        ];
    }

    public static function motortipusOptions(): array
    {
        return [
            1 => Yii::t("app", "Dízel"),
            2 => Yii::t("app", "Benzines"),
        ];
    }

    public static function valtoOptions(): array
    {
        return [
            1 => Yii::t("app", "Manuális"),
            2 => Yii::t("app", "Automata"),
        ];
    }

    public static function vetelarOptions()
    {
        return ArrayHelper::map(Arvalaszto::find()->all(), 'id', 'megnevezes');
    }

    public static function evjaratOptions()
    {
        return ArrayHelper::map(Idoszakok::find()->all(), 'id', 'idoszak_megnevezes');
    }

    public static function ugyfelOptions(): array
    {
        return ArrayHelper::map(Ugyfelek::find()->all(), "id", "nev");
    }

    public static function teljesitmenyOptions(): array
    {
        return [
            "0-100"   => "0-100 KW",
            "100-200" => "100-200 KW",
            "200-300" => "200-300 KW",
            "400-500" => "400-500 KW",
            "500+"    => "500+ KW",
        ];
    }

    public static function sorbarendezes(): array
    {
        return [
            "vetelar asc"       => Yii::t("app", "Vetelar novekvo"),
            "vetelar desc"      => Yii::t("app", "Vetelar csokkeno"),
            "kilometer asc"     => Yii::t("app", "Kilometer novekvo"),
            "kilometer desc"    => Yii::t("app", "Kilometer csokkeno"),
            "gyartasi_ev asc"   => Yii::t("app", "Gyartasi Ev novekvo"),
            "gyartasi_ev desc"  => Yii::t("app", "Gyartasi Ev csokkeno"),
            "teljesitmeny asc"  => Yii::t("app", "Teljesitmeny novekvo"),
            "teljesitmeny desc" => Yii::t("app", "Teljesitmeny csokkeno"),
        ];
    }

    public static function kilometerOptions(): array
    {
        return [
            "0-100"   => "0-100 ezer",
            "100-200" => "100-200 ezer",
            "200-300" => "200-300 ezer",
            "400-500" => "400-500 ezer",
            "500+"    => "500+ ezer",
        ];
    }

}
