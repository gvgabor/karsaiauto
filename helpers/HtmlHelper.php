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

    public static function felszereltsegBox(Autok $model)
    {
        $felszereltsegBox = Html::div()->class();

        if (count($model->felszereltsegList)) {
            $liList = [];
            foreach ($model->felszereltsegList as $item) {
                $li = Html::li()->addContent(
                    Html::i()->class("fas fa-check-circle"),
                    Yii::t("app", $item->name)
                );
                $liList[] = $li;
            }
            $felszereltsegBox = $felszereltsegBox->addContent(
                Html::div()->class("extrak-lista")->addContent(
                    Html::h3()->content(Yii::t("app", "Extrak"))->addContent(
                        Html::i()->class("fas fa-star")
                    ),
                    Html::ul()->items(...$liList)
                )
            );
        }

        return $felszereltsegBox->render();
    }

    public static function adatokBoxGrid(Autok $model)
    {
        $adatokGridBox = Html::div()->class("adatok-grid-box");
        $properties    = [
            [
                "label" => Yii::t("app", "Evjarat"),
                "i"     => "fas fa-calendar-alt",
                "value" => $model->gyartasi_ev,
            ],
            [
                "label" => Yii::t("app", "Kilometer"),
                "i"     => "fas fa-tachometer-alt",
                "value" => $model->formatKilometer . " KM",
            ],
            [
                "label" => Yii::t("app", "Motortipus ID"),
                "i"     => "fas fa-oil-can",
                "value" => $model->motortipus,
            ],
            [
                "label" => Yii::t("app", "Valto ID"),
                "i"     => "fas fa-cogs",
                "value" => $model->valto,
            ],
            [
                "label" => Yii::t("app", "Muszaki Ervenyes"),
                "i"     => "fas fa-wrench",
                "value" => $model->muszaki_ervenyes,
            ],
            [
                "label" => Yii::t("app", "Teljesitmeny"),
                "i"     => "fas fa-bolt",
                "value" => $model->tejlesitmenyText,
            ],
        ];

        if ($model->szinek_id) {
            $properties[] = [
                "label" => Yii::t("app", "Szinek ID"),
                "i"     => "fas fa-fill-drip",
                "value" => $model->szinek->szin_neve,
            ];
        }

        if ($model->kivitel_id) {
            $properties[] = [
                "label" => Yii::t("app", "Kivitel ID"),
                "i"     => "fas fa-car-side",
                "value" => $model->kivitel->name,
            ];
        }

        $children = [];

        foreach ($properties as $item) {
            $children[] = Html::div()->addContent(
                Html::i()->class($item['i']),
                Html::span()->content($item['label']),
                Html::span()->content($item['value']),
            );
        }

        $adatokGridBox = $adatokGridBox->addContent(...$children);
        return $adatokGridBox->render();
    }

}
