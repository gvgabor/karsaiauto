<?php

namespace app\modules\autok\models;

use app\models\base\Autok;

final class EladasModel extends Autok
{
    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['eladas_datuma', 'eladas_ugyfel_id'], 'required']
        ]);
    }

}
