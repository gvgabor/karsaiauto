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

    public static function formCheckBox($label, $id)
    {
        $chekboxMain = Html::div("{input}")
            ->addContent(
                Html::label()->class("checkbox")->forId($id)
                    ->addContent(
                        Html::span()->class("checkbox__inner")
                            ->addContent(Html::span()->class("green__ball"))
                    ),
                Html::div()->class("checkbox__text")
                    ->addContent(
                        Html::span($label),
                        Html::div()->class("checkbox__text--options")
                            ->addContent(
                                Html::span("NEM")->class("off"),
                                Html::span("IGEN")->class("on"),
                            )
                    )
            )
            ->class("chekbox-main")
            ->encode(false);

        return $chekboxMain->render();
    }

}
