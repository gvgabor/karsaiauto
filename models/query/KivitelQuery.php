<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Kivitel]].
 *
 * @see \app\models\Kivitel
 */
class KivitelQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Kivitel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Kivitel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
