<?php

namespace app\models;

use app\components\MainActiveRecord;
use app\models\query\AutokQuery;
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
 * @property string|null $teljesitmeny
 * @property int|null $valto_id
 * @property string|null $muszaki_ervenyes
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
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
     * @return AutokQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AutokQuery(get_called_class());
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
                    'teljesitmeny',
                    'valto_id',
                    'muszaki_ervenyes',
                    'created_at',
                    'updated_at',
                    'updated_by',
                    'create_by'
                ],
                'default',
                'value' => null
            ],
            [['deleted'], 'default', 'value' => 0],
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
                    'create_by'
                ],
                'integer'
            ],
            [['hirdetes_leirasa'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['model', 'hirdetes_cime', 'teljesitmeny', 'muszaki_ervenyes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'jarmutipus_id'    => Yii::t('app', 'Jarmutipus ID'),
            'marka_id'         => Yii::t('app', 'Marka ID'),
            'model'            => Yii::t('app', 'Model'),
            'gyartasi_ev'      => Yii::t('app', 'Gyartasi Ev'),
            'kilometer'        => Yii::t('app', 'Kilometer'),
            'vetelar'          => Yii::t('app', 'Vetelar'),
            'hirdetes_cime'    => Yii::t('app', 'Hirdetes Cime'),
            'hirdetes_leirasa' => Yii::t('app', 'Hirdetes Leirasa'),
            'motortipus_id'    => Yii::t('app', 'Motortipus ID'),
            'teljesitmeny'     => Yii::t('app', 'Teljesitmeny'),
            'valto_id'         => Yii::t('app', 'Valto ID'),
            'muszaki_ervenyes' => Yii::t('app', 'Muszaki Ervenyes'),
            'deleted'          => Yii::t('app', 'Deleted'),
            'active'           => Yii::t('app', 'Active'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
            'updated_by'       => Yii::t('app', 'Updated By'),
            'create_by'        => Yii::t('app', 'Create By'),
        ];
    }

}
