<?php

namespace app\models\base;

use app\models\query\MenuQuery;

/**
 *
 * @property-read bool $hasChild
 * @property-read Menu $parent
 */
class Menu extends \app\models\Menu
{
    public int $diveder = 0;

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['menu_name', 'sorrend'], 'required']
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();

        $fields["parent_name"] = function () {
            $parentArray = [];
            $parentList  = $this->findParent($this, $parentArray);
            $parentList  = array_reverse($parentList);
            return join("&nbsp;<i class='fa fa-arrow-right'></i>&nbsp;", $parentList);
        };
        $fields["hasChild"] = function () {
            return $this->hasChild;
        };
        return $fields;
    }

    public function findParent($model, array &$parentList)
    {
        $parent = $model->parent;
        if (!empty($parent)) {
            $parentList[] = $parent->menu_name;
            $this->findParent($model->parent, $parentList);
        }
        return $parentList;
    }

    public function getParent()
    {
        return $this->hasOne(Menu::class, ["id" => "parent_id"]);
    }

    public function getHasChild(): bool
    {
        $child = Menu::find()->andWhere(["parent_id" => $this->id])->one();
        return !empty($child);
    }

    public static function find()
    {
        return new MenuQuery(get_called_class());
    }

    public function possibleParentList(Menu $currentModel)
    {
        $possibleList = Menu::find()->andWhere([
            "and",
            ["IS", "menu_url", null],
            ["IS", "parent_id", null]
        ])->all();

        $options             = [];
        $currentChildrenList = [];
        $this->childList($currentModel, $currentChildrenList);
        $currentChildrenList[] = $currentModel->id;
        foreach ($possibleList as $model) {
            $list     = [];
            $children = $this->childList($model, $list);

            if ($model->id != $currentModel->id) {
                $options[$model->id] = $model->menu_name;
            }

            foreach ($children as $item) {
                $child = Menu::findOne($item);
                if (in_array($child->id, $currentChildrenList)) {
                    continue;
                }
                $init       = [];
                $parentList = $this->findParent($child, $init);
                $parentList = array_reverse($parentList);
                $label      = "";
                foreach ($parentList as $parent) {
                    $label .= $parent . "-";
                }
                $options[$child->id] = $label . $child->menu_name;
            }

        }

        return $options;
    }

    public function childList($model, &$list)
    {
        if ($model->isNewRecord) {
            return [];
        }
        $children = Menu::find()->andWhere(["parent_id" => $model->id])->all();
        foreach ($children as $item) {
            $list[] = $item->id;
            $this->childList($item, $list);
        }
        return $list;
    }

}
