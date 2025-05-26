<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "felhasznaloi_jogok".
 *
 * @property int $id
 * @property string|null $jogosultsag_neve
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class FelhasznaloiJogok extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'felhasznaloi_jogok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['jogosultsag_neve', 'created_at', 'updated_at', 'updated_by', 'create_by'], 'default', 'value' => null],
            [['deleted'], 'default', 'value' => 0],
            [['active'], 'default', 'value' => 1],
            [['deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['jogosultsag_neve'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'jogosultsag_neve' => Yii::t('app', 'Jogosultsag Neve'),
            'deleted'          => Yii::t('app', 'Deleted'),
            'active'           => Yii::t('app', 'Active'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
            'updated_by'       => Yii::t('app', 'Updated By'),
            'create_by'        => Yii::t('app', 'Create By'),
        ];
    }

}
