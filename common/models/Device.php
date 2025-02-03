<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "device".
 *
 * @property int $id
 * @property string|null $device_id
 * @property string|null $device_type Android/iOS etc
 * @property string|null $make iphone
 * @property string|null $model 14 pro max
 * @property string|null $os 16.1
 * @property string|null $name
 * @property string|null $email
 * @property string|null $mobile
 * @property string|null $create_time when did user started using our app
 * @property string|null $update_time
 *
 * @property DevicePreferences[] $devicePreferences
 */
class Device extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'device';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['device_id', 'device_type'], 'string', 'max' => 500],
            [['make', 'model', 'os', 'name', 'email', 'mobile'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'device_id' => Yii::t('app', 'Device ID'),
            'device_type' => Yii::t('app', 'Device Type'),
            'make' => Yii::t('app', 'Make'),
            'model' => Yii::t('app', 'Model'),
            'os' => Yii::t('app', 'Os'),
            'name' => Yii::t('app', 'Name'),
            'email' => Yii::t('app', 'Email'),
            'mobile' => Yii::t('app', 'Mobile'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[DevicePreferences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevicePreferences()
    {
        return $this->hasMany(DevicePreferences::class, ['device_id' => 'id']);
    }
}
