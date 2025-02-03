<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property string|null $code
 * @property string|null $en
 * @property string|null $ar
 * @property string|null $bg_color
 * @property string|null $fg_color
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'en', 'ar', 'bg_color', 'fg_color'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Code'),
            'en' => Yii::t('app', 'En'),
            'ar' => Yii::t('app', 'Ar'),
            'bg_color' => Yii::t('app', 'Bg Color'),
            'fg_color' => Yii::t('app', 'Fg Color'),
        ];
    }

    static function readStatus($code, $lang = null) {
        $lang = $lang ?? Yii::$app->language;
        $model = Status::find()
            ->where(['code' => $code])
            ->one();

        if (!isset($model)) {
            return $code;
        }

        switch ($lang) {
            case 'ur':
                return $model->ur;
            case 'ar':
                return $model->ar;
            default:
                return $model->en;
        }
    }
}
