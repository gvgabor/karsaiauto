<?php

namespace app\helpers;

use Yii;

class ColumnsHelper
{
    public static function felhasznalokColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "felhasznaloi_nev", "title" => Yii::t("app", "Felhasznaloi Nev")];
        $columns[] = ["field" => "jogosultsag_neve", "title" => Yii::t("app", "Jogosultsag Neve")];
        $columns[] = ["field" => "email", "title" => Yii::t("app", "Email")];
        $columns[] = [
            "command"    => ["template" => '<button class="btn btn-danger jelszo-valtoztatas-btn"><i class="fa-solid fa-key"></i>&nbsp;Jelszó változtatás</button>'],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 200,
        ];
        $columns = array_merge($columns, self::adminColumns());
        return $columns;
    }

    public static function adminColumns(): array
    {
        $columns[] = [
            "command" => [
                "template" => "<button data-name='edit-btn' class='btn btn-warning  edit-btn rounded-0'><i class='fa fa-pen-alt'></i></button>"
            ],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 60,
        ];
        $columns[] = [
            "command"    => ["template" => "<button data-name='remove-btn' class='btn btn-danger  remove-btn rounded-0'><i class='fa fa-trash-alt'></i></button>"],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 60,
        ];

        return $columns;
    }

    public static function idoszakokColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "idoszak_megnevezes", "title" => Yii::t("app", "Idoszak Megnevezes")];
        return $columns;
    }

    public static function arvalasztoColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "megnevezes", "title" => Yii::t("app", "Megnevezes")];
        $columns[] = ["field" => "kezdo_osszeg", "title" => Yii::t("app", "Kezdo Osszeg")];
        $columns[] = ["field" => "veg_osszeg", "title" => Yii::t("app", "Veg Osszeg")];
        return $columns;
    }

    public static function menuColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "menu_name", "title" => Yii::t("app", "Menu Name")];
        $columns[] = ["field" => "parent_name", "title" => Yii::t("app", "Parent ID"), "encoded" => false];
        $columns[] = ["field" => "menu_url", "title" => Yii::t("app", "Menu Url")];
        $columns[] = [
            "field"      => "sorrend",
            "title"      => Yii::t("app", "Sorrend"),
            "attributes" => ["style" => "text-align:center"],
        ];
        $columns[] = [
            "command"    => ["name" => "edit", "text" => "alma"],
            "attributes" => ["style" => "text-align:center", "data-name" => "edit-td"],
            "width"      => 60,
            "encoded"    => false
        ];
        $columns[] = [
            "command"    => ["name" => "delete", "text" => "alma"],
            "attributes" => ["style" => "text-align:center", "data-name" => "delete-td"],
            "width"      => 60,
            "encoded"    => false
        ];

        return $columns;
    }

    public static function markakColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "name", "title" => Yii::t("app", "Name")];
        $columns[] = ["field" => "friendly_name", "title" => Yii::t("app", "Friendly Name")];
        $columns   = array_merge($columns, self::adminColumns());

        return $columns;
    }

    public static function hozzarendelesMenuColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "menu_name", "title" => Yii::t("app", "Menu Name")];
        //        $columns[] = [
        //            "field"      => "sorrend",
        //            "title"      => Yii::t("app", "Sorrend"),
        //            "attributes" => ["style" => "text-align:center"],
        //            "width"      => 120
        //        ];
        $columns[] = ["field" => "parent_name", "title" => Yii::t("app", "Parent ID"), "encoded" => false];
        $columns[] = [
            "command"    => ["name" => "delete", "text" => "alma"],
            "attributes" => ["style" => "text-align:center", "data-name" => "hozzaad-td"],
            "width"      => 60,
            "encoded"    => false
        ];
        return $columns;
    }

    public static function hozzarendelveMenuColumns(): array
    {
        $columns[] = [
            "command"    => ["name" => "delete", "text" => "alma"],
            "attributes" => ["style" => "text-align:center", "data-name" => "hozzaad-td"],
            "width"      => 60,
            "encoded"    => false
        ];
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "menu_name", "title" => Yii::t("app", "Menu Name")];
        $columns[] = ["field" => "parent_name", "title" => Yii::t("app", "Parent ID"), "encoded" => false];
        //        $columns[] = [
        //            "field"      => "sorrend",
        //            "title"      => Yii::t("app", "Sorrend"),
        //            "attributes" => ["style" => "text-align:center"],
        //            "width"      => 120
        //        ];

        return $columns;
    }

    public static function felhasznaloiJogokColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "jogosultsag_neve", "title" => Yii::t("app", "Jogosultsag Neve")];
        $columns[] = ["field" => "felhasznalok", "title" => Yii::t("app", "Felhasznalok")];
        $columns[] = [
            "field"      => "felhasznalok_szama",
            "title"      => Yii::t("app", "Felhasznalok Szama"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 230,
        ];
        $columns[] = [
            "command"    => ["template" => "<button class='btn btn-danger  hozzarendeles-btn rounded-0'><i class=\"fa-solid fa-toggle-on\"></i>&nbsp;Hozzárendelés</button>"],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 180,
        ];

        $columns = array_merge($columns, self::adminColumns());
        return $columns;
    }

}
