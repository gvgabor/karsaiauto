<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\FelhasznaloiJogokMenu]].
 *
 * @see \app\models\FelhasznaloiJogokMenu
 */
class FelhasznaloiJogokMenuQuery extends \app\components\MainActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function findCurrent(int $menuId, int $felhasznaloiJogokId): FelhasznaloiJogokMenuQuery
    {
        $this->andWhere([
            "menu_id"               => $menuId,
            "felhasznaloi_jogok_id" => $felhasznaloiJogokId,
            "deleted"               => 0,
        ]);
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\FelhasznaloiJogokMenu[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    public function menuIdList($felhasznaloiJogId): FelhasznaloiJogokMenuQuery
    {
        $this->select(["menu_id"])->andWhere(["felhasznaloi_jogok_id" => $felhasznaloiJogId])->column();
        return $this;
    }

    /**
     * {@inheritdoc}
     * @return \app\models\FelhasznaloiJogokMenu|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
