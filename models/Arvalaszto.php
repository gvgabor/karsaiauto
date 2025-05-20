<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arvalaszto".
 *
 * @property int $id
 * @property string|null $megnevezes
 * @property int|null $kezdo_osszeg
 * @property int|null $veg_osszeg
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Arvalaszto extends \app\components\MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arvalaszto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['megnevezes', 'kezdo_osszeg', 'veg_osszeg', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['kezdo_osszeg', 'veg_osszeg', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['megnevezes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'           => Yii::t('app', 'ID'),
            'megnevezes'   => Yii::t('app', 'Megnevezes'),
            'kezdo_osszeg' => Yii::t('app', 'Kezdo Osszeg'),
            'veg_osszeg'   => Yii::t('app', 'Veg Osszeg'),
            'deleted'      => Yii::t('app', 'Deleted'),
            'active'       => Yii::t('app', 'Active'),
            'created_at'   => Yii::t('app', 'Created At'),
            'updated_at'   => Yii::t('app', 'Updated At'),
            'updated_by'   => Yii::t('app', 'Updated By'),
            'create_by'    => Yii::t('app', 'Create By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ArvalasztoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArvalasztoQuery(get_called_class());
    }

}
