<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "autok".
 *
 * @property int $id
 * @property int|null $jarmutipus_id
 * @property int|null $marka_id
 * @property string|null $model
 * @property int|null $gyartasi_ev
 * @property int|null $kilometer
 * @property int|null $vetelar
 * @property string|null $hirdetes_cime
 * @property string|null $hirdetes_leirasa
 * @property int|null $motortipus_id
 * @property int|null $valto_id
 * @property string|null $muszaki_ervenyes
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 * @property int|null $publikalva
 * @property int|null $eladva
 * @property int|null $akcios
 * @property int|null $fooldalra
 * @property int|null $akcios_ar
 * @property string|null $eladas_datuma
 * @property string|null $eladas_megjegyzes
 * @property int|null $eladas_ugyfel_id
 * @property int|null $teljesitmeny
 */
abstract class Autok extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'jarmutipus_id',
                    'marka_id',
                    'model',
                    'gyartasi_ev',
                    'kilometer',
                    'vetelar',
                    'hirdetes_cime',
                    'hirdetes_leirasa',
                    'motortipus_id',
                    'valto_id',
                    'muszaki_ervenyes',
                    'created_at',
                    'updated_at',
                    'updated_by',
                    'create_by',
                    'akcios_ar',
                    'eladas_datuma',
                    'eladas_megjegyzes',
                    'eladas_ugyfel_id',
                    'teljesitmeny'
                ],
                'default',
                'value' => null
            ],
            [['fooldalra'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [
                [
                    'jarmutipus_id',
                    'marka_id',
                    'gyartasi_ev',
                    'kilometer',
                    'vetelar',
                    'motortipus_id',
                    'valto_id',
                    'deleted',
                    'active',
                    'updated_by',
                    'create_by',
                    'publikalva',
                    'eladva',
                    'akcios',
                    'fooldalra',
                    'akcios_ar',
                    'eladas_ugyfel_id',
                    'teljesitmeny'
                ],
                'integer'
            ],
            [['hirdetes_leirasa', 'eladas_megjegyzes'], 'string'],
            [['created_at', 'updated_at', 'eladas_datuma'], 'safe'],
            [['model', 'hirdetes_cime', 'muszaki_ervenyes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'jarmutipus_id'     => Yii::t('app', 'Jarmutipus ID'),
            'marka_id'          => Yii::t('app', 'Marka ID'),
            'model'             => Yii::t('app', 'Model'),
            'gyartasi_ev'       => Yii::t('app', 'Gyartasi Ev'),
            'kilometer'         => Yii::t('app', 'Kilometer'),
            'vetelar'           => Yii::t('app', 'Vetelar'),
            'hirdetes_cime'     => Yii::t('app', 'Hirdetes Cime'),
            'hirdetes_leirasa'  => Yii::t('app', 'Hirdetes Leirasa'),
            'motortipus_id'     => Yii::t('app', 'Motortipus ID'),
            'valto_id'          => Yii::t('app', 'Valto ID'),
            'muszaki_ervenyes'  => Yii::t('app', 'Muszaki Ervenyes'),
            'deleted'           => Yii::t('app', 'Deleted'),
            'active'            => Yii::t('app', 'Active'),
            'created_at'        => Yii::t('app', 'Created At'),
            'updated_at'        => Yii::t('app', 'Updated At'),
            'updated_by'        => Yii::t('app', 'Updated By'),
            'create_by'         => Yii::t('app', 'Create By'),
            'publikalva'        => Yii::t('app', 'Publikalva'),
            'eladva'            => Yii::t('app', 'Eladva'),
            'akcios'            => Yii::t('app', 'Akcios'),
            'fooldalra'         => Yii::t('app', 'Fooldalra'),
            'akcios_ar'         => Yii::t('app', 'Akcios Ar'),
            'eladas_datuma'     => Yii::t('app', 'Eladas Datuma'),
            'eladas_megjegyzes' => Yii::t('app', 'Eladas Megjegyzes'),
            'eladas_ugyfel_id'  => Yii::t('app', 'Eladas Ugyfel ID'),
            'teljesitmeny'      => Yii::t('app', 'Teljesitmeny'),
        ];
    }

}
