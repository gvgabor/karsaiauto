<?php

namespace app\components;

use LogicException;
use ReflectionClass;
use yii\db\ActiveRecord;

/**
 * @property-read string $shortname
 * @property-read array $adminColumns
 * @property-read string $longId
 */
abstract class MainActiveRecord extends ActiveRecord
{
    public static function find()
    {
        return new MainActiveQuery(get_called_class());
    }

    public static function findOrCreate(array $formData)
    {
        if (array_key_exists("id", $formData) && !empty($formData["id"])) {
            return self::findOne($formData["id"]);
        } else {
            return new static();
        }
    }

    public function getAdminColumns()
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

    public function softDelete()
    {


        if (array_key_exists("deleted", $this->attributes) === false) {
            throw new LogicException('A softDelete() használatához "deleted" mező kell.');
        }

        $this->deleted = true;

        return $this->save(false);
    }

    public function getShortname(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function getLongId()
    {
        return str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }


}
