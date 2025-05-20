<?php

namespace app\components;

use yii\db\ActiveQuery;

/**
 * @see MainActiveRecord
 */
class MainActiveQuery extends ActiveQuery
{

    public function init()
    {
        parent::init();
        $this->andWhere(['deleted' => 0]);
    }

    public function withDeleted()
    {
        return $this->andWhere([]);
    }

}