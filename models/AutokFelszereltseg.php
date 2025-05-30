<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "autok_felszereltseg".
 *
 * @property int $id
 * @property int|null $felszereltseg_id
 * @property int|null $autok_id
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class AutokFelszereltseg extends \app\components\MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autok_felszereltseg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['felszereltseg_id', 'autok_id', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['felszereltseg_id', 'autok_id', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'felszereltseg_id' => Yii::t('app', 'Felszereltseg ID'),
            'autok_id'         => Yii::t('app', 'Autok ID'),
            'deleted'          => Yii::t('app', 'Deleted'),
            'active'           => Yii::t('app', 'Active'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
            'updated_by'       => Yii::t('app', 'Updated By'),
            'create_by'        => Yii::t('app', 'Create By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AutokFelszereltsegQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AutokFelszereltsegQuery(get_called_class());
    }

}
