<?php

namespace app\models\base;

use app\models\query\SzinekQuery;

/**
 *
 */
class Szinek extends \app\models\Szinek
{
    public static function find()
    {
        return new SzinekQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['szin_neve'], 'required'],
            [['szin_neve'], 'unique','filter' => fn () => $this->deleted == 0],
        ]);
    }

    public function fields()
    {
        $fields         = parent::fields();
        $fields["name"] = fn () => $this->szin_neve;
        return $fields;
    }

}
