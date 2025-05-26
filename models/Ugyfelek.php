<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "ugyfelek".
 *
 * @property int $id
 * @property string|null $nev
 * @property string|null $email
 * @property string|null $telefon
 * @property string|null $lakcim
 * @property string|null $cegnev
 * @property string|null $adoszam
 * @property string|null $szuletesi_datum
 * @property string|null $szemelyi_szam
 * @property int|null $tipus 1 magánszemély 2 cég
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Ugyfelek extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ugyfelek';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'nev',
                    'email',
                    'telefon',
                    'lakcim',
                    'cegnev',
                    'adoszam',
                    'szuletesi_datum',
                    'szemelyi_szam',
                    'created_at',
                    'updated_at',
                    'updated_by',
                    'create_by'
                ],
                'default',
                'value' => null
            ],
            [['active'], 'default', 'value' => 1],
            [['deleted'], 'default', 'value' => 0],
            [['szuletesi_datum', 'created_at', 'updated_at'], 'safe'],
            [['tipus', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['nev', 'email', 'telefon', 'lakcim', 'cegnev', 'adoszam', 'szemelyi_szam'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'nev'             => Yii::t('app', 'Nev'),
            'email'           => Yii::t('app', 'Email'),
            'telefon'         => Yii::t('app', 'Telefon'),
            'lakcim'          => Yii::t('app', 'Lakcim'),
            'cegnev'          => Yii::t('app', 'Cegnev'),
            'adoszam'         => Yii::t('app', 'Adoszam'),
            'szuletesi_datum' => Yii::t('app', 'Szuletesi Datum'),
            'szemelyi_szam'   => Yii::t('app', 'Szemelyi Szam'),
            'tipus'           => Yii::t('app', 'Tipus'),
            'deleted'         => Yii::t('app', 'Deleted'),
            'active'          => Yii::t('app', 'Active'),
            'created_at'      => Yii::t('app', 'Created At'),
            'updated_at'      => Yii::t('app', 'Updated At'),
            'updated_by'      => Yii::t('app', 'Updated By'),
            'create_by'       => Yii::t('app', 'Create By'),
        ];
    }

}
