<?php

namespace app\models\base;

use app\models\query\FelhasznaloiJogokMenuQuery;

/**
 *
 * @property-read FelhasznaloiJogok $felhasznaloiJogok
 */
class FelhasznaloiJogokMenu extends \app\models\FelhasznaloiJogokMenu
{
    public static function find()
    {
        return new FelhasznaloiJogokMenuQuery(get_called_class());
    }

    public function getFelhasznaloiJogok()
    {
        return $this->hasOne(FelhasznaloiJogok::class, ["id" => "felhasznaloi_jogok_id"]);
    }

}
