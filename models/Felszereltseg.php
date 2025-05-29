<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "felszereltseg".
 *
 * @property int $id
 * @property string|null $name
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Felszereltseg extends \app\components\MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'felszereltseg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'name'       => Yii::t('app', 'Name'),
            'deleted'    => Yii::t('app', 'Deleted'),
            'active'     => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'create_by'  => Yii::t('app', 'Create By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\FelszereltsegQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FelszereltsegQuery(get_called_class());
    }

}
