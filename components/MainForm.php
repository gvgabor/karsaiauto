<?php

namespace app\components;

use yii\bootstrap5\ActiveField;
use yii\bootstrap5\ActiveForm;

class MainForm extends ActiveForm
{
    public function init()
    {
        $this->options["onsubmit"]    = "return false;";
        $this->enableClientValidation = false;
        $this->enableClientScript     = false;
        parent::init();
    }

    public function field($model, $attribute, $options = []): ActiveField
    {
        $item = parent::field($model, $attribute, $options);
        /** @var MainActiveRecord $current */
        $current = $model;
        $label   = $model->getAttributeLabel($attribute);
        if ($current->isAttributeRequired($attribute)) {
            $item->label()->label(vsprintf("%s *", [$label]));
        }

        return $item;

    }

}
