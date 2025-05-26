<?php

namespace app\helpers;

use app\models\base\FelhasznaloiJogok;
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

    public static function ugyfelOptions(): array
    {
        return ArrayHelper::map(Ugyfelek::find()->all(), "id", "nev");
    }

}
