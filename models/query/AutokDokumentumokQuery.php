<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\AutokDokumentumok]].
 *
 * @see \app\models\AutokDokumentumok
 */
class AutokDokumentumokQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \app\models\AutokDokumentumok[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\AutokDokumentumok|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
