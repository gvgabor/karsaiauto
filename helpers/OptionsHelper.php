<?php

namespace app\helpers;

use app\models\base\FelhasznaloiJogok;
use yii\helpers\ArrayHelper;

class OptionsHelper
{

    public static function felhasznaloiJogokOptions(): array
    {
        return ArrayHelper::map(FelhasznaloiJogok::find()->all(), "id", "jogosultsag_neve");
    }

}