<?php

namespace app\models\base;

use app\models\query\FelhasznalokQuery;
use Yii;
use yii\web\IdentityInterface;

/**
 *
 * @property-read void $authKey
 * @property-read string $username
 * @property-read FelhasznaloiJogok $felhasznaloiJogok
 */
class Felhasznalok extends \app\models\Felhasznalok implements IdentityInterface
{
    public const SCENARIO_JELSZO = 'jelszo';
    public const SCENARIO_LOGIN  = 'login';

    public ?string $jelszo1 = null;
    public ?string $jelszo2 = null;

    public static function find()
    {
        return new FelhasznalokQuery(get_called_class());
    }

    public static function findByUsername($username)
    {
        return static::findOne(['felhasznaloi_nev' => $username, 'deleted' => 0]);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {

    }


    public function createSubMenu(Menu $menuItem, array $menuAssignmentIdList, string &$text)
    {
        $text .= '<ul class="dropdown-menu shadow">';
        $children = Menu::find()
            ->andWhere(["deleted" => 0])
            ->andWhere(["active" => 1])
            ->andWhere(["IN", "id", $menuAssignmentIdList])
            ->andWhere(["parent_id" => $menuItem->id])
            ->orderBy(["sorrend" => SORT_ASC])
            ->all();

        foreach ($children as $child) {
            if ($child->getHasChild()) {
                $text .= vsprintf('%s<li class="dropend">', [$child->diveder == 1 ? '<li><hr class="dropdown-divider"></li>' : ""]);
                $text .= '<a href="#" class="dropdown-item dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside">' . $this->menuicon . '&nbsp;' . Yii::t("app", $child->menu_name) . '</a>';
                $this->createSubMenu($child, $menuAssignmentIdList, $text);
                $text .= '</li>';
            } else {
                $text .= vsprintf('<li><a class="dropdown-item" href="%s">%s&nbsp;' . Yii::t("app", $child->menu_name) . '</a></li>', [
                    $child->menu_url ? Yii::$app->urlManager->createAbsoluteUrl($child->menu_url) : "#",
                    $this->menuicon,
                    $child->diveder == 1 ? '<li><hr class="dropdown-divider"></li>' : ""
                ]);
            }
        }
        $text .= '</ul>';
        return $text;
    }


    /**
     * @return string
     */
    public function getMenuicon()
    {
        return '<i class="fa-sharp fa-solid fa-circle"></i>&nbsp;';
    }



    public function getHtmlMenu(): string
    {
        $menuAssignmentIdList = FelhasznaloiJogokMenu::find()
            ->andWhere(["felhasznaloi_jogok_id" => $this->felhasznaloi_jog])
            ->select(["menu_id"])
            ->createCommand()
            ->queryColumn();
        $menuList = Menu::find()
            ->andWhere(["active" => 1])
            ->andWhere(["IS", "parent_id", null])
            ->andWhere(["IN", "id", $menuAssignmentIdList])
            ->orderBy(["sorrend" => SORT_ASC]);
        $menuList = $menuList->all();
        $menuHtml = '<ul class="navbar-nav mr-auto mb-2 mb-lg-0">';
        foreach ($menuList as $menuItem) {
            if (!$menuItem->getHasChild()) {
                $menuHtml .= vsprintf('<li class="nav-item">
<!--suppress HtmlUnknownTarget -->
<a class="nav-link" aria-current="page" href="%s">%s&nbsp;%s</a>
</li>', [
                    $menuItem->menu_url ? Yii::$app->urlManager->createAbsoluteUrl($menuItem->menu_url) : "#",
                    $this->menuicon,
                    Yii::t("app", $menuItem->menu_name)
                ]);
            } else {
                $text = '<li class="nav-item dropdown">';
                $text .= '<a
                            class="nav-link dropdown-toggle"
                            href="#"
                            data-bs-toggle="dropdown"
                            data-bs-auto-close="outside">' . $this->menuicon . '&nbsp;' . Yii::t("app", $menuItem->menu_name) . '
                    </a>';
                $this->createSubmenu($menuItem, $menuAssignmentIdList, $text);
                $text     .= "</li>";
                $menuHtml .= $text;
            }
        }
        $menuHtml .= "</ul>";
        return $menuHtml;
    }


    public function scenarios()
    {
        $scenarios                        = parent::scenarios();
        $scenarios[self::SCENARIO_JELSZO] = ['jelszo1', 'jelszo2'];
        $scenarios[self::SCENARIO_LOGIN]  = ['felhasznaloi_nev', 'jelszo'];
        return $scenarios;
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['felhasznaloi_nev', 'felhasznaloi_jog', 'felhasznaloi_nev', 'email'], 'required'],
            [
                ['felhasznaloi_nev'],
                'unique',
                'filter' => fn () => $this->deleted = 0,
                'except' => self::SCENARIO_LOGIN
            ],
            [['jelszo1', 'jelszo2'], 'safe',],
            [['felhasznaloi_nev', 'jelszo'], 'required', 'on' => self::SCENARIO_LOGIN],
            [['email'], 'email'],
            [['jelszo1', 'jelszo2'], 'required', 'on' => self::SCENARIO_JELSZO],
            [['jelszo2'], 'compare', 'compareAttribute' => 'jelszo1', 'on' => self::SCENARIO_JELSZO]
        ]);
    }

    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'jelszo1' => 'Új jelszó',
            'jelszo2' => 'Új jelszó mégegyszer',
        ]);
    }

    public function getUsername()
    {
        return $this->felhasznaloi_nev;
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->jelszo = Yii::$app->security->generatePasswordHash($this->jelszo);
        }
        return parent::beforeSave($insert);
    }

    public function fields()
    {
        $fields = parent::fields();
        unset($fields["jelszo"]);
        unset($fields["deleted"]);
        unset($fields["active"]);
        $fields["jogosultsag_neve"] = fn () => $this->felhasznaloiJogok?->jogosultsag_neve;
        return $fields;
    }

    public function getFelhasznaloiJogok()
    {
        return $this->hasOne(FelhasznaloiJogok::class, ["id" => "felhasznaloi_jog"]);
    }

    public function extraFields()
    {
        return ["felhasznaloiJogok"];
    }

    public function getId()
    {
        return $this->id;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->jelszo);
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getAuthKey()
    {
        return $this->auth_key ?? null; // vagy amit használsz
    }
}
