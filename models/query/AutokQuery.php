<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Autok]].
 *
 * @see \app\models\Autok
 */
class AutokQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\Autok[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\Autok|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function akciosAutok(): AutokQuery
    {
        $this->andWhere([
            "akcios"     => 1,
            "eladva"     => 0,
            "publikalva" => 1,
        ])
            ->orderBy(["updated_at" => SORT_DESC])
            ->limit($_ENV['AKCIOS_AUTOK_LIMIT']);
        return $this;
    }

    public function kiemeltAutok()
    {
        $this->andWhere([
            "fooldalra"  => 1,
            "eladva"     => 0,
            "publikalva" => 1,
        ])
            ->orderBy(["updated_at" => SORT_DESC])
            ->limit($_ENV['KIEMELT_AUTOK_LIMIT']);
        return $this;
    }

}
