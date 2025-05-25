<?php

namespace app\components\behaviors;

use yii\base\Behavior;
use yii\base\Model;

class NumericSanitizeBehavior extends Behavior
{
    /**
     * A model mezői, amiket meg akarunk tisztítani (formázott számmezők)
     * @var array
     */
    public array $attributes = [];

    /**
     * Események, amikhez a viselkedés csatlakozik
     */
    public function events()
    {
        return [
            Model::EVENT_BEFORE_VALIDATE => 'sanitizeAttributes',
        ];
    }

    /**
     * Számmezők megtisztítása
     */
    public function sanitizeAttributes()
    {
        foreach ($this->attributes as $attr) {
            if (!empty($this->owner->$attr)) {
                // csak szám karakterek megtartása (pl. "1 000 000" → "1000000")
                $this->owner->$attr = preg_replace('/\D/', '', $this->owner->$attr);
            }
        }
    }
}
