<?php

namespace app\helpers;

use Yii;
use yii\helpers\Url;
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

    public static function languageSelector()
    {
        $languages = [];

        $langs = [
            "Magyar"  => "hu-HU",
            "English" => "en-US"
        ];

        foreach ($langs as $key => $item) {
            $url         = Url::to(["/autok/index", "lang" => $item]);
            $languages[] = Html::li()->addContent(
                Html::a()->class("dropdown-item")->href($url)->addContent('<i class="fa-sharp fa-solid fa-circle" ></i>&nbsp;&nbsp;' . $key)->encode(false),
            );
        }

        $li = Html::li()
            ->class("nav-item dropdown")
            ->addContent(
                Html::a("Nyelvek")
                    ->href("#")
                    ->class("nav-link dropdown-toggle")
                    ->addAttributes([
                        "data-bs-toggle"     => "dropdown",
                        "data-bs-auto-close" => "outside"
                    ]),
                Html::ul()
                    ->class("dropdown-menu shadow")
                    ->items(...$languages)
            );

        return $li->encode(false)->render();
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
                                Html::span(Yii::t("app", "nem"))->class("off"),
                                Html::span(Yii::t("app", "igen"))->class("on"),
                            )
                    )
            )
            ->class("chekbox-main")
            ->encode(false);

        return $chekboxMain->render();
    }

}
