<?php

namespace app\helpers;

use Yiisoft\Html\Html;

class HtmlHelper
{
    public static function hozzaadasBtn($content, $id)
    {
        $button = Html::button('<i class="fa-solid fa-square-plus"></i>&nbsp;')
            ->addClass("btn btn-danger")
            ->id($id)
            ->addContent($content)
            ->encode(false);
        return $button->render();
    }

}
