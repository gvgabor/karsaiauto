<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\AutokFelszereltseg]].
 *
 * @see \app\models\AutokFelszereltseg
 */
class AutokFelszereltsegQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\AutokFelszereltseg[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\AutokFelszereltseg|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
