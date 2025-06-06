<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\FelhasznaloiJogok]].
 *
 * @see \app\models\FelhasznaloiJogok
 */
class FelhasznaloiJogokQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\FelhasznaloiJogok[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\FelhasznaloiJogok|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
