<?php

namespace app\models\index;

use app\models\base\Autok;
use ReflectionClass;
use Yii;
use yii\base\Model;

/**
 *
 * @property-read Autok $auto
 * @property-read string $shortname
 */
class KapcsolatModel extends Model
{
    public mixed $nev    = null;
    public mixed $email  = null;
    public mixed $targy  = null;
    public mixed $uzenet = null;
    public mixed $autoId = null;

    public function rules()
    {
        return [
            [['nev', 'email', 'uzenet', 'targy'], 'required'],
            [['nev', 'email', 'targy'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['autoId'], 'integer'],
            [['uzenet'], 'string', 'max' => 1000],
        ];
    }

    public function getAuto(): Autok
    {
        return Autok::findOne($this->autoId);
    }

    public function getShortname()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    public function attributeLabels()
    {
        return [
            'uzenet' => Yii::t("app", "Uzenet"),
            'targy'  => Yii::t("app", "Targy"),
            'nev'    => Yii::t("app", "Szemely Nev"),
            'email'  => Yii::t("app", "Email"),
        ];
    }

}
