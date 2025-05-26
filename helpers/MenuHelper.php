<?php

namespace app\helpers;

use app\models\base\FelhasznaloiJogok;
use app\models\base\Menu;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Li;

class MenuHelper
{
    public static function createMenu($felhasznaloiJogokId)
    {
        $felhasznaloiJogok = FelhasznaloiJogok::findOne($felhasznaloiJogokId);
        $menu              = Html::ul()
            ->class("navbar-nav me-auto mb-2 mb-lg-0");
        $menuList     = $felhasznaloiJogok->menuList;
        $rootElements = array_filter($menuList, fn (Menu $item) => $item->parent_id === null);

        $list = [];
        foreach ($rootElements as $item) {

            $link = Html::a($item->menu_name)
                ->addClass("nav-link")
                ->addAttributes(["aria-current" => "page"])
                ->href($item->menu_url ?? "#");
            $li = Html::li()->addClass("nav-item")->encode(false);

            if ($item->hasChild) {
                $link = $link->addClass("dropdown-toggle")->addAttributes([
                    "role"           => "button",
                    "data-bs-toggle" => "dropdown",
                    "aria-expanded"  => "false",
                ]);
                $li      = $li->addClass("dropdown")->addContent($link);
                $current = $item;
                $liList  = [];
                self::createChilden($item, $li, $liList);

            } else {
                $li = $li->addContent($link);
            }

            $list[] = $li;
        }

        $menu = $menu->items(...$list);
        d($menu->render());
        return $menu;
    }

    public static function createChilden(Menu $current, Li &$li, array &$liList)
    {
        $children = Menu::find()->andWhere(["parent_id" => $current->id])->all();
        $ul       = Html::ul()->addClass("dropdown-menu");

        foreach ($children as $item) {
            $link = Html::a($item->menu_name)
                ->addClass("dropdown-item")
                ->href($item->menu_url ?? "#");
            $currentLi = Html::li();
            $hasChild  = $item->hasChild;
            if ($hasChild) {

                //                $link = Html::a($item->menu_name)
                //                    ->addClass("nav-link")
                //                    ->addAttributes(["aria-current" => "page"])
                //                    ->href($item->menu_url ?? "#");
                //                $link = $link->addClass("dropdown-toggle")->addAttributes([
                //                    "role"           => "button",
                //                    "data-bs-toggle" => "dropdown",
                //                    "aria-expanded"  => "false",
                //                ]);
                //                $currentLi = $currentLi->addContent($link);
                $link = Html::a($item->menu_name)->href("#")->addAttributes([
                    "role"           => "button",
                    "data-bs-toggle" => "dropdown",
                    "aria-expanded"  => "false",
                ]);
                $currentLi = Html::li()->addClass("dropdown")->addContent($link);
                self::createChilden($item, $currentLi, $liList);
            } else {
                $currentLi = $currentLi->addContent($link);
            }

            $liList[] = $currentLi;
        }
        $ul = $ul->items(...$liList);
        $li = $li->addContent($ul);
    }

}
