<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "translation".
 *
 * @property int $id
 * @property string $code
 * @property string|null $en
 * @property string|null $ur
 * @property string|null $ar
 */
class Translation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'translation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['en', 'ur', 'ar'], 'string'],
            [['code'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'en' => Yii::t('app', 'En'),
            'ur' => Yii::t('app', 'Ur'),
            'ar' => Yii::t('app', 'Ar'),
        ];
    }
}
