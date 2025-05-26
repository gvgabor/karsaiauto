<?php

namespace app\components;

use app\components\behaviors\ActiveRecordBehavior;
use yii\db\ActiveQuery;

/**
 * @see MainActiveRecord
 */
class MainActiveQuery extends ActiveQuery
{
    public function init()
    {
        parent::init();
        $tablename = $this->getPrimaryTableName();
        $this->andWhere([$tablename . "." . 'deleted' => 0]);
    }

    public function withDeleted()
    {
        return $this->andWhere([]);
    }


}
