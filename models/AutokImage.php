<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "autok_image".
 *
 * @property int $id
 * @property int|null $autok_id
 * @property int|null $sorrend
 * @property string|null $name
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class AutokImage extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'autok_image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['autok_id', 'name', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['autok_id', 'sorrend', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
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
            'autok_id'   => Yii::t('app', 'Autok ID'),
            'sorrend'    => Yii::t('app', 'Sorrend'),
            'name'       => Yii::t('app', 'Name'),
            'deleted'    => Yii::t('app', 'Deleted'),
            'active'     => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'create_by'  => Yii::t('app', 'Create By'),
        ];
    }

}
