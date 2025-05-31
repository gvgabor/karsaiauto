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
    public mixed $marka                = null;
    public mixed $evjarat              = null;
    public mixed $vetelar              = null;
    public mixed $jarmutipus           = null;
    public mixed $motortipus           = null;
    public mixed $valto                = null;
    public mixed $teljesitmeny         = null;
    public mixed $kilometer            = null;
    public mixed $sorbarendezes        = null;
    public mixed $szin                 = null;
    public mixed $kivitel              = null;
    public mixed $ajtokszama           = null;
    public mixed $szallithatoSzemelyek = null;
    public mixed $sajatTomeg           = null;
    public mixed $ossztomeg            = null;
    public mixed $terhelhetoseg        = null;
    public mixed $tengelytav           = null;
    public mixed $hosszusag            = null;
    public mixed $szelesseg            = null;
    public mixed $hengerek_szama       = null;
    public mixed $hengerurtartalom     = null;

    public function rules()
    {
        return [
            [
                ['vetelar', 'marka', 'evjarat', 'jarmutipus', 'motortipus', 'valto', 'szin', 'kivitel'],
                'filter',
                'filter' => 'intval'
            ],
            [
                [
                    'teljesitmeny',
                    'kilometer',
                    'sorbarendezes',
                    'ajtokszama',
                    'szallithatoSzemelyek',
                    'sajatTomeg',
                    'ossztomeg',
                    'terhelhetoseg',
                    'tengelytav',
                    'hosszusag',
                    'szelesseg',
                    'hengerek_szama',
                    'hengerurtartalom',
                ],
                'string',
                'max' => 255
            ]
        ];
    }

    public function attributeLabels()
    {
        return [
            'marka'                => Yii::t('app', 'Marka ID'),
            'evjarat'              => Yii::t('app', 'Evjarat'),
            'vetelar'              => Yii::t('app', 'Vetelar'),
            'jarmutipus'           => Yii::t('app', 'Jarmutipus ID'),
            'motortipus'           => Yii::t('app', 'Motortipus ID'),
            'valto'                => Yii::t('app', 'Valto ID'),
            'teljesitmeny'         => Yii::t('app', 'Teljesitmeny'),
            'kilometer'            => Yii::t('app', 'Kilometer'),
            'sorbarendezes'        => Yii::t('app', 'Sorbarendezes'),
            'kivitel'              => Yii::t('app', 'Kivitel ID'),
            'szin'                 => Yii::t('app', 'Szinek'),
            'ajtokszama'           => Yii::t('app', 'Ajtok Szam'),
            'tengelytav'           => Yii::t('app', 'Tengelytav'),
            'szallithatoSzemelyek' => Yii::t('app', 'Szallithato Szemelyek'),
            'sajatTomeg'           => Yii::t('app', 'Sajat Tomeg'),
            'ossztomeg'            => Yii::t('app', 'Ossztomeg'),
            'terhelhetoseg'        => Yii::t('app', 'Terhelhetoseg'),
            'hosszusag'            => Yii::t('app', 'Hosszusag'),
            'szelesseg'            => Yii::t('app', 'Szelesseg'),
            'hengerek_szama'       => Yii::t('app', 'Hengerek Szama'),
            'hengerurtartalom'     => Yii::t('app', 'Hengerurtartalom'),
        ];
    }

    public function getShortname(): string
    {
        return (new ReflectionClass($this))->getShortName();
    }

}
