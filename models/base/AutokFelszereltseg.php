<?php

namespace app\models\base;

use app\models\query\AutokFelszereltsegQuery;

/**
 *
 * @property-read Felszereltseg $felszereltseg
 * @property-read Autok $autok
 */
class AutokFelszereltseg extends \app\models\AutokFelszereltseg
{
    public static function find()
    {
        return new AutokFelszereltsegQuery(get_called_class());
    }

    public function getAutok()
    {
        return $this->hasOne(Autok::class, ['id' => 'autok_id']);
    }

    public function getFelszereltseg()
    {
        return $this->hasOne(Felszereltseg::class, ['id' => 'felszereltseg_id']);
    }

}
