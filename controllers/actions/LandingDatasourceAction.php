<?php

namespace app\controllers\actions;

use app\components\enums\LandingDataSourceType;
use app\components\MainAction;
use app\models\index\LandingAutok;
use Yii;
use yii\web\Response;

class LandingDatasourceAction extends MainAction
{
    public int $type = LandingDataSourceType::AKCIOS->value;

    public function runWithParams($params)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $query                      = LandingAutok::find();

        if ($this->type === LandingDataSourceType::AKCIOS->value) {
            $query->akciosAutok();
        }

        if ($this->type === LandingDataSourceType::KIEMELT->value) {
            $query->kiemeltAutok();
        }

        return [
            "total" => $query->limit,
            "data"  => $query->all(),
        ];
    }

}
