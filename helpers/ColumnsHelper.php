<?php

namespace app\helpers;

use Yii;
use yii\helpers\Json;

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

    public static function dokumentumokColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "name", "title" => Yii::t("app", "Megnevezes")];
        $columns[] = [
            "field"      => "extension",
            "title"      => Yii::t("app", "Kiterjesztes"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 120,
        ];
        $columns[] = [
            "command"    => ["template" => "<button data-name='remove-btn' class='btn btn-danger  remove-btn rounded-0'><i class='fa fa-trash-alt'></i></button>"],
            "attributes" => ["style" => "text-align:center", "data-delete-text" => Yii::t("app", "Dokumentum Torlese")],
            "width"      => 60,
        ];
        $columns[] = [
            "command"    => ["template" => "<button data-name='view-btn' class='btn btn-primary  view-btn rounded-0'><i class=\"fa-solid fa-up-right-from-square\"></i></button>"],
            "attributes" => ["style" => "text-align:center", "data-delete-text" => Yii::t("app", "Dokumentum Torlese")],
            "width"      => 60,
        ];
        return $columns;
    }

    public static function autokColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];

        $muveletek = [
            ["id" => "eladas", "text" => Yii::t("app", "Eladas"), "icon" => "gear"],
            ["id" => "adatlap", "text" => Yii::t("app", "Webes Nezet"), "icon" => "gear"],
            ["id" => "oldal", "text" => Yii::t("app", "Oldal Nezet"), "icon" => "gear"],
        ];


        $columns[] = [
            "command" => [
                "template" => sprintf("<button class='btn btn-primary action-btn'><i class=\"fa-solid fa-square-check\"></i>&nbsp;%s</button>", Yii::t("app", "Muveletek"))
            ],
            "attributes" => [
                "style"          => "text-align:center",
                "data-muveletek" => htmlspecialchars(Json::encode($muveletek))
            ],
            "width"   => 180,
            "locked"  => true,
            "encoded" => false,
        ];

        $columns[] = [
            "field"    => "azonosito",
            "title"    => Yii::t("app", "Azonosito"),
            "locked"   => true,
            "width"    => 170,
            "sortable" => false,
        ];

        $columns[] = [
            "field"  => "marka",
            "title"  => Yii::t("app", "Marka ID"),
            "locked" => true,
            "width"  => 230
        ];
        $columns[] = [
            "field"  => "model",
            "title"  => Yii::t("app", "Model"),
            "locked" => true,
            "width"  => 230
        ];
        $columns[] = [
            "field"      => "vetelar",
            "title"      => Yii::t("app", "Vetelar"),
            "attributes" => ["style" => "text-align:right"],
            "locked"     => true,
            "width"      => 230
        ];
        $columns[] = [
            "field"      => "gyartasi_ev",
            "title"      => Yii::t("app", "Gyartasi Ev"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
            "sortable"   => false,
        ];
        $columns[] = [
            "field"      => "fooldalra",
            "title"      => Yii::t("app", "Fooldalra"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
        ];
        $columns[] = [
            "field"      => "eladva",
            "title"      => Yii::t("app", "Eladva"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
            "sortable"   => false,
        ];
        $columns[] = [
            "field"      => "akcios",
            "title"      => Yii::t("app", "Akcios"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
            "sortable"   => false,
        ];
        $columns[] = [
            "field"      => "publikalva",
            "title"      => Yii::t("app", "Publikalva"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
            "filterable" => true,
            "sortable"   => false,
        ];
        $columns[] = [
            "field"      => "kepek_szama",
            "title"      => Yii::t("app", "Kepek Szama"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 160,
            "sortable"   => false,
        ];
        $columns[] = [
            "field"      => "dokumentumok_szama",
            "title"      => Yii::t("app", "Dokumentumok Szama"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 200,
            "sortable"   => false,
        ];

        $columns[] = [
            "field"  => "hirdetes_cime",
            "title"  => Yii::t("app", "Hirdetes Cime"),
            "locked" => false,
        ];

        foreach ($columns as $key => $value) {
            if (array_key_exists("locked", $value) === false) {
                $columns[$key]["locked"] = false;
            }
            if (array_key_exists("width", $value) === false) {
                $columns[$key]["width"] = 200;
            }
        }

        $columns = array_merge(self::adminColumnsLock(), $columns);
        return $columns;
    }

    public static function adminColumnsLock(): array
    {
        $columns[] = [
            "command" => [
                "template" => "<button data-name='edit-btn' class='btn btn-warning  edit-btn rounded-0'><i class='fa fa-pen-alt'></i></button>"
            ],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 60,
            "locked"     => true
        ];
        $columns[] = [
            "command"    => ["template" => "<button data-name='remove-btn' class='btn btn-danger  remove-btn rounded-0'><i class='fa fa-trash-alt'></i></button>"],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 60,
            "locked"     => true
        ];

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
            "command"    => ["template" => "<button class='btn btn-danger  hozzarendeles-btn rounded-0 text-nowrap'><i class=\"fa-solid fa-toggle-on\"></i>&nbsp;Hozzárendelés</button>"],
            "attributes" => ["style" => "text-align:center"],
            "width"      => 180,
        ];

        $columns = array_merge($columns, self::adminColumns());
        return $columns;
    }

    public static function ugyfelekColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = [
            "field"  => "nev",
            "title"  => Yii::t("app", "Nev"),
            "locked" => true
        ];
        $columns[] = [
            "field"      => "tipus",
            "title"      => Yii::t("app", "Tipus"),
            "attributes" => ["style" => "text-align:left"],
            "width"      => 155,
        ];
        $columns[] = [
            "field"      => "telefon",
            "title"      => Yii::t("app", "Telefon"),
            "attributes" => ["style" => "text-align:left"],
            "width"      => 180,
            "locked"     => true
        ];
        $columns[] = [
            "field"  => "email",
            "title"  => Yii::t("app", "Email"),
            "locked" => true
        ];
        $columns[] = [
            "field"      => "lakcim",
            "title"      => Yii::t("app", "Lakcim"),
            "attributes" => ["style" => "text-align:left;"],
        ];
        $columns[] = ["field" => "cegnev", "title" => Yii::t("app", "Cegnev")];
        $columns[] = [
            "field"      => "adoszam",
            "title"      => Yii::t("app", "Adoszam"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 170,
        ];
        $columns[] = [
            "field"      => "szuletesi_datum",
            "title"      => Yii::t("app", "Szuletesi Datum"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 190,
        ];
        $columns[] = [
            "field"      => "szemelyi_szam",
            "title"      => Yii::t("app", "Szemelyi Szam"),
            "attributes" => ["style" => "text-align:center"],
            "width"      => 170,
        ];

        foreach ($columns as $key => $value) {
            if (array_key_exists("locked", $value) === false) {
                $columns[$key]["locked"] = false;
            }
            if (array_key_exists("width", $value) === false) {
                $columns[$key]["width"] = 200;
            }
        }

        $columns = array_merge(self::adminColumnsLock(), $columns);
        return $columns;
    }

    public static function baseColumns(): array
    {
        $columns[] = ["field" => "id", "title" => Yii::t("app", "ID"), "hidden" => true];
        $columns[] = ["field" => "name", "title" => Yii::t("app", "Name")];
        $columns   = array_merge($columns, self::adminColumns());
        return $columns;
    }

}
