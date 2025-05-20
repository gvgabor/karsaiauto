<?php

namespace app\helpers;

use app\models\base\FelhasznaloiJogok;
use app\models\base\Markak;
use yii\helpers\ArrayHelper;

class OptionsHelper
{
    public static function felhasznaloiJogokOptions(): array
    {
        return ArrayHelper::map(FelhasznaloiJogok::find()->all(), "id", "jogosultsag_neve");
    }

    public static function markakOptions(): array
    {
        return ArrayHelper::map(Markak::find()->all(), "id", "name");
    }

    public static function jarmutipusaOptions(): array
    {
        return [
            1 => "Kisteherautó",
            2 => "Személyautó",
        ];
    }

    public static function motortipusOptions(): array
    {
        return [
            1 => "Dízel",
            2 => "Benzines",
        ];
    }

    public static function valtoOptions(): array
    {
        return [
            1 => "Manuális",
            2 => "Automata",
        ];
    }

}
