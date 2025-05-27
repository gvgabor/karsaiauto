<?php

namespace app\helpers;

use app\models\base\Autok;
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
            "HU" => "hu-HU",
            "EN" => "en-US",
            "FR" => "fr-FR",
        ];

        foreach ($langs as $key => $item) {
            $url = Url::to(["/index/change-language", "lang" => $item]);
            $li  = Html::li(
                Html::a()->class("nav-link")->href($url)->addContent($key)
            )->class("nav-item lang-item");
            if (Yii::$app->language == $item) {
                $li = $li->addClass("current-lang");
            }
            $languages[] = $li;
        }

        return $languages;
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

    public static function vetelarBox(Autok $model)
    {
        $box     = Html::div()->class("vetelar-box");
        $vetelar = Html::span()->class("h5 text-primary")->addContent($model->formatVetelar . " Ft");

        if ($model->akcios) {
            $vetelar  = $vetelar->addClass("athuzott");
            $akciosar = Html::span()->class("h5 text-primary")->addContent($model->formatAkciosar . " Ft");
            $box      = $box->addContent($vetelar, $akciosar);
        } else {
            $box = $box->addContent($vetelar);
        }

        return $box->render();

    }

    public static function igenNemFilters(): string
    {
        $data = [
            ["id" => 1, "value" => Yii::t("app", "igen")],
            ["id" => 0, "value" => Yii::t("app", "nem")],
        ];
        return htmlspecialchars(json_encode($data));
    }

}
