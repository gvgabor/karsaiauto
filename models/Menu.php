<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "_menu".
 *
 * @property int $id
 * @property string|null $menu_name
 * @property string|null $menu_url
 * @property int|null $parent_id
 * @property int|null $sorrend
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Menu extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['menu_name', 'menu_url', 'parent_id', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['parent_id', 'sorrend', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['menu_name', 'menu_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'menu_name'  => Yii::t('app', 'Menu Name'),
            'menu_url'   => Yii::t('app', 'Menu Url'),
            'parent_id'  => Yii::t('app', 'Parent ID'),
            'sorrend'    => Yii::t('app', 'Sorrend'),
            'deleted'    => Yii::t('app', 'Deleted'),
            'active'     => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'create_by'  => Yii::t('app', 'Create By'),
        ];
    }

}
