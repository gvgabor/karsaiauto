<?php

namespace app\models\base;

use app\models\query\IdoszakokQuery;

class Idoszakok extends \app\models\Idoszakok
{
    public static function find()
    {
        return new IdoszakokQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['idoszak_megnevezes'], 'required'],
            [['idoszak_megnevezes'], 'filter', 'filter' => 'trim'],
        ]);
    }

}
