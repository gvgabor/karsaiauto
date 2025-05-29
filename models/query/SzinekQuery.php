<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Szinek]].
 *
 * @see \app\models\Szinek
 */
class SzinekQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Szinek[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Szinek|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
