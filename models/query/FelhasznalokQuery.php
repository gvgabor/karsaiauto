<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Felhasznalok]].
 *
 * @see \app\models\Felhasznalok
 */
class FelhasznalokQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Felhasznalok[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Felhasznalok|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function orderById()
    {
        $this->orderBy(["{{%felhasznalok}}.id" => SORT_DESC]);
        return $this;
    }
}
