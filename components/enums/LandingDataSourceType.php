<?php

namespace app\components\enums;

use Yii;

enum LandingDataSourceType: int
{
    case AKCIOS  = 1;
    case KIEMELT = 2;

    public static function list(): array
    {
        return [
            self::AKCIOS->value  => Yii::t("app", self::AKCIOS->label()),
            self::KIEMELT->value => Yii::t("app", self::KIEMELT->label()),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::AKCIOS  => 'Akciós',
            self::KIEMELT => 'Kiemelt',
        };
    }

}
