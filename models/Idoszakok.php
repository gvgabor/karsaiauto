<?php

namespace app\models;

use app\components\MainActiveRecord;
use app\models\query\IdoszakokQuery;
use Yii;

/**
 * This is the model class for table "idoszakok".
 *
 * @property int $id
 * @property string|null $idoszak_megnevezes
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Idoszakok extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'idoszakok';
    }

    /**
     * {@inheritdoc}
     * @return IdoszakokQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IdoszakokQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idoszak_megnevezes', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['idoszak_megnevezes'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                 => Yii::t('app', 'ID'),
            'idoszak_megnevezes' => Yii::t('app', 'Idoszak Megnevezes'),
            'deleted'            => Yii::t('app', 'Deleted'),
            'active'             => Yii::t('app', 'Active'),
            'created_at'         => Yii::t('app', 'Created At'),
            'updated_at'         => Yii::t('app', 'Updated At'),
            'updated_by'         => Yii::t('app', 'Updated By'),
            'create_by'          => Yii::t('app', 'Create By'),
        ];
    }

}
