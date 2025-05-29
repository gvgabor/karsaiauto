<?php

namespace app\models\base;

use app\models\query\FelszereltsegQuery;

class Felszereltseg extends \app\models\Felszereltseg
{
    public static function find()
    {
        return new FelszereltsegQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['name'], 'required'],
            [['name'], 'unique','filter' => fn () => $this->deleted == 0],
        ]);
    }

}
