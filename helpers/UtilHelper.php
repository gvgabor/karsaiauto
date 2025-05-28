<?php

namespace app\helpers;

use app\models\index\FilterModel;
use Yii;

class UtilHelper
{
    public static function isLocal()
    {
        $path = Yii::getAlias("@runtime/local.lock");
        return is_file($path);
    }

    public static function filterModel(): FilterModel
    {
        return Yii::$app->session->get("filterModel", new FilterModel());
    }

}
