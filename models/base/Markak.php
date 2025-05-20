<?php

namespace app\models\base;

use app\models\query\MarkakQuery;
use yii\helpers\Inflector;

class Markak extends \app\models\Markak
{
    public static function find()
    {
        return new MarkakQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['name'], 'required'],
            [
                ['name'],
                'unique',
                'filter' => fn () => $this->deleted = 0
            ],
        ]);
    }

    public function beforeSave($insert)
    {
        $this->friendly_name = Inflector::slug($this->name);
        $this->name          = mb_strtoupper($this->name);
        return parent::beforeSave($insert);
    }

}
