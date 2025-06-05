<?php

namespace app\helpers;

use app\models\base\Arvalaszto;
use app\models\base\FelhasznaloiJogok;
use app\models\base\Felszereltseg;
use app\models\base\Idoszakok;
use app\models\base\Kivitel;
use app\models\base\Markak;
use app\models\base\Szinek;
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
            2 => Yii::t("app", "Szemelyauto"),
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

    public static function ajtokOptions(): array
    {
        return [
            "1-2" => "1-2",
            "2-4" => "2-4",
            "5+"  => "5+",
        ];
    }

    public static function tomegOptions(): array
    {
        return [
            "0-1000"    => "0-1000 kg",
            "1000-2000" => "1000-2000 kg",
            "2000-3000" => "2000-3000 kg",
            "3000-4000" => "3000-4000 kg",
            "4000-5000" => "4000-5000 kg",
            "5000+"     => "5000+ kg",
        ];
    }

    public static function meretOptions(): array
    {
        return [
            "0-1000"    => "0-1000 mm",
            "1000-2000" => "1000-2000 mm",
            "2000-3000" => "2000-3000 mm",
            "3000-4000" => "3000-4000 mm",
            "4000-5000" => "4000-5000 mm",
            "5000+"     => "5000+ mm",
        ];
    }

    public static function hengerurtartalomOptions(): array
    {
        return [
            "0-999"     => "0 – 999 cm³",
            "1000-1399" => "1000 – 1399 cm³",
            "1400-1599" => "1400 – 1599 cm³",
            "1600-1799" => "1600 – 1799 cm³",
            "1800-1999" => "1800 – 1999 cm³",
            "2000-2499" => "2000 – 2499 cm³",
            "2500-2999" => "2500 – 2999 cm³",
            "3000-3499" => "3000 – 3499 cm³",
            "3500-3999" => "3500 – 3999 cm³",
            "4000-4999" => "4000 – 4999 cm³",
            "5000+"     => "5000 cm³ felett",
        ];
    }

    public static function hengerSzamOptions(): array
    {
        return [
            "1"  => "1 henger",
            "2"  => "2 henger",
            "3"  => "3 henger",
            "4"  => "4 henger",
            "5"  => "5 henger",
            "6"  => "6 henger",
            "8"  => "8 henger (V8)",
            "10" => "10 henger (V10)",
            "12" => "12 henger (V12)",
            "16" => "16 henger (V16)",
        ];
    }

    public static function szallithatoSzemelyekOptions(): array
    {
        return [
            "1-2" => "1-2",
            "2-4" => "2-4",
            "5+"  => "5+",
        ];
    }

    public static function szinekOptions()
    {
        return ArrayHelper::map(Szinek::find()->all(), "id", "szin_neve");
    }

    public static function kivitelOptions()
    {
        return ArrayHelper::map(Kivitel::find()->all(), "id", "name");
    }

    public static function felszereltsegOptions()
    {
        return ArrayHelper::map(Felszereltseg::find()->orderBy(["name" => SORT_ASC])->all(), "id", "name");
    }

}
