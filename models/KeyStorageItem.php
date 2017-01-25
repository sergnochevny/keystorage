<?php

namespace lun324\keystorage\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "key_storage_item".
 *
 * @property integer $key
 * @property integer $value
 */
class KeyStorageItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%key_storage_item}}';
    }

    public function behaviors()
    {
        return [
            [
              'class' => TimestampBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['name'], 'string', 'max'=>128],
            [['value', 'comment'], 'safe'],
            [['name'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('key-storage', 'Key'),
            'value' => Yii::t('key-storage', 'Value'),
            'comment' => Yii::t('key-storage', 'Comment'),
        ];
    }
}
