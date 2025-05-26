<?php

namespace app\helpers;

use Yii;

class UtilHelper
{
    public static function isLocal()
    {
        $path = Yii::getAlias("@runtime/local.lock");
        return is_file($path);
    }

}
