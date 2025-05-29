<?php

namespace app\models\base;

use app\models\query\KivitelQuery;

class Kivitel extends \app\models\Kivitel
{
    public static function find()
    {
        return new KivitelQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['name'], 'required'],
            [['name'], 'unique','filter' => fn () => $this->deleted == 0],
        ]);
    }

}
