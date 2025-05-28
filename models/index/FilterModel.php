<?php

namespace app\models\index;

use ReflectionClass;
use Yii;
use yii\base\Model;

/**
 *
 * @property-read string $shortname
 */
class FilterModel extends Model
{
    public mixed $marka         = null;
    public mixed $evjarat       = null;
    public mixed $vetelar       = null;
    public mixed $jarmutipus    = null;
    public mixed $motortipus    = null;
    public mixed $valto         = null;
    public mixed $teljesitmeny  = null;
    public mixed $kilometer     = null;
    public mixed $sorbarendezes = null;

    public function rules()
    {
        return [
            [['vetelar', 'marka', 'evjarat', 'jarmutipus', 'motortipus', 'valto'], 'filter', 'filter' => 'intval'],
            [['teljesitmeny', 'kilometer','sorbarendezes'], 'string', 'max' => 255]
        ];
    }

    public function attributeLabels()
    {
        return [
            'marka'         => Yii::t('app', 'Marka ID'),
            'evjarat'       => Yii::t('app', 'Evjarat'),
            'vetelar'       => Yii::t('app', 'Vetelar'),
            'jarmutipus'    => Yii::t('app', 'Jarmutipus ID'),
            'motortipus'    => Yii::t('app', 'Motortipus ID'),
            'valto'         => Yii::t('app', 'Valto ID'),
            'teljesitmeny'  => Yii::t('app', 'Teljesitmeny'),
            'kilometer'     => Yii::t('app', 'Kilometer'),
            'sorbarendezes' => Yii::t('app', 'Sorbarendezes'),
        ];
    }

    public function getShortname(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

}
