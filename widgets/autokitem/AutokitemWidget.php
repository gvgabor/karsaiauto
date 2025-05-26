<?php

namespace app\widgets\autokitem;

use app\models\index\LandingAutok;
use yii\base\Widget;

class AutokitemWidget extends Widget
{
    public ?LandingAutok $model = null;

    public function run()
    {
        return $this->render("list-item", ["model" => $this->model]);
    }

}
