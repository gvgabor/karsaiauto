<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "felhasznaloi_jogok_menu".
 *
 * @property int $id
 * @property int|null $felhasznaloi_jogok_id
 * @property int|null $menu_id
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class FelhasznaloiJogokMenu extends \app\components\MainActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'felhasznaloi_jogok_menu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['felhasznaloi_jogok_id', 'menu_id', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['felhasznaloi_jogok_id', 'menu_id', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'felhasznaloi_jogok_id' => Yii::t('app', 'Felhasznaloi Jogok ID'),
            'menu_id' => Yii::t('app', 'Menu ID'),
            'deleted' => Yii::t('app', 'Deleted'),
            'active' => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'create_by' => Yii::t('app', 'Create By'),
        ];
    }

}
