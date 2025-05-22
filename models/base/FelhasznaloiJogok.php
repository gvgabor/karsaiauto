<?php

namespace app\models\base;

use app\models\query\FelhasznaloiJogokQuery;
use Yii;
use yii\helpers\Inflector;

/**
 *
 * @property-read string $role
 * @property-read mixed $jogneve
 * @property-read Felhasznalok[] $felhasznalok
 */
class FelhasznaloiJogok extends \app\models\FelhasznaloiJogok
{
    public static function find()
    {
        return new FelhasznaloiJogokQuery(get_called_class());
    }

    public function rules()
    {
        return array_merge_recursive(parent::rules(), [
            [['jogosultsag_neve'], 'required'],
            [
                ['jogosultsag_neve'],
                'unique',
                'filter' => function () {
                    return $this->deleted = 0;
                }
            ]
        ]);
    }

    public function getJogneve()
    {
        return Yii::t("app", $this->jogosultsag_neve);
    }

    public function getRole(): string
    {
        return Yii::$app->authManager->getRole(Inflector::slug($this->jogosultsag_neve, "_"))->name;
    }

    public function fields()
    {
        $fields                       = parent::fields();
        $fields["felhasznalok_szama"] = fn () => count($this->felhasznalok);
        $fields["felhasznalok"]       = function () {
            return implode(",", $this->getFelhasznalok()->select(["{{%felhasznalok}}.felhasznaloi_nev"])->column());
        };
        return $fields;
    }

    public function getFelhasznalok()
    {
        return $this->hasMany(Felhasznalok::class, ['felhasznaloi_jog' => 'id']);
    }

    public function extraFields()
    {
        return ["alma" => 1];
    }

}
