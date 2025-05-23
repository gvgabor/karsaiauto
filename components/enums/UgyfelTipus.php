<?php

namespace app\components\enums;

use Yii;

enum UgyfelTipus: int
{
    case MAGAN = 1;
    case CEG   = 2;

    public static function list(): array
    {
        return [
            self::MAGAN->value => Yii::t("app", self::MAGAN->label()),
            self::CEG->value   => Yii::t("app", self::CEG->label()),
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::MAGAN => 'Magánszemély',
            self::CEG   => 'Cég',
        };
    }
}
