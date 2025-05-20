<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Markak]].
 *
 * @see \app\models\Markak
 */
class MarkakQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Markak[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Markak|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
