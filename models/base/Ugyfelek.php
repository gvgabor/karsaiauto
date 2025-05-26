<?php

namespace app\models\base;

use app\components\enums\UgyfelTipus;
use app\models\query\UgyfelekQuery;

class Ugyfelek extends \app\models\Ugyfelek
{
    public static function find()
    {
        return new UgyfelekQuery(get_called_class());
    }

    public function fields()
    {
        $fields = parent::fields();

        if ($this->tipus) {
            $fields["tipus"] = fn () => UgyfelTipus::tryFrom($this->tipus)->label();
        }


        $fields["szemelyi_szam"] = fn () => $this->tipus === UgyfelTipus::CEG->value ? null : $this->szemelyi_szam;

        $fields["szuletesi_datum"] = fn () => $this->tipus === UgyfelTipus::CEG->value ? null : $this->szuletesi_datum;

        $fields["adoszam"] = fn () => $this->tipus === UgyfelTipus::MAGAN->value ? null : $this->adoszam;

        $fields["cegnev"] = fn () => $this->tipus === UgyfelTipus::MAGAN->value ? null : $this->cegnev;
        return $fields;
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['nev', 'telefon', 'tipus'], 'required'],
            [['email'], 'email'],
            [['tipus'], 'in', 'range' => array_keys(UgyfelTipus::list())]
        ]);
    }
}
