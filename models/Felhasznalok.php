<?php

namespace app\models;

use app\components\MainActiveRecord;
use Yii;

/**
 * This is the model class for table "felhasznalok".
 *
 * @property int $id
 * @property string|null $felhasznaloi_nev
 * @property string|null $jelszo
 * @property string|null $email
 * @property int|null $felhasznaloi_jog
 * @property int $deleted
 * @property int $active
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int|null $updated_by
 * @property int|null $create_by
 */
abstract class Felhasznalok extends MainActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'felhasznalok';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'felhasznaloi_nev',
                    'jelszo',
                    'email',
                    'felhasznaloi_jog',
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
            [['felhasznaloi_jog', 'deleted', 'active', 'updated_by', 'create_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['felhasznaloi_nev', 'jelszo', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'felhasznaloi_nev' => Yii::t('app', 'Felhasznaloi Nev'),
            'jelszo'           => Yii::t('app', 'Jelszo'),
            'email'            => Yii::t('app', 'Email'),
            'felhasznaloi_jog' => Yii::t('app', 'Felhasznaloi Jog'),
            'deleted'          => Yii::t('app', 'Deleted'),
            'active'           => Yii::t('app', 'Active'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
            'updated_by'       => Yii::t('app', 'Updated By'),
            'create_by'        => Yii::t('app', 'Create By'),
        ];
    }

}
