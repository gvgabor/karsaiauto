<?php

namespace app\models\base;

use app\models\query\ArvalasztoQuery;

class Arvalaszto extends \app\models\Arvalaszto
{
    public static function find()
    {
        return new ArvalasztoQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['kezdo_osszeg', 'megnevezes'], 'required'],
            [['megnevezes'], 'filter', 'filter' => 'trim']
        ]);
    }

}
