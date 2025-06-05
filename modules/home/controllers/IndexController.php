<?php

namespace app\modules\home\controllers;

use app\components\MainController;

class IndexController extends MainController
{
    public function actionIndex()
    {
        return $this->render("index");
    }

}
