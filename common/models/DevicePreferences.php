<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "device_preferences".
 *
 * @property int $id
 * @property int|null $device_id
 * @property string|null $project provider_app, client_app, etc.
 * @property string|null $title last_used, views, likes, etc.
 * @property string|null $value
 *
 * @property Device $device
 */
class DevicePreferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'device_preferences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_id'], 'integer'],
            [['value'], 'string'],
            [['project', 'title'], 'string', 'max' => 255],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => Device::class, 'targetAttribute' => ['device_id' => 'id']],
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
            'project' => Yii::t('app', 'Project'),
            'title' => Yii::t('app', 'Title'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * Gets query for [[Device]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }

    public function getDeviceDetail($project, $userId, $key = 'last_used') {
        if ($key == 'name') {
            $user = User::findOne($userId);
            if (!empty($user)) {
                $name = $user->name;
                return $name ?? null;
            }
        }

        $device = DevicePreferences::find()
            ->where(['project' => $project])
            ->andWhere(['title' => 'user_id'])
            ->andWhere(['value' => $userId])
            ->one();

        if ($device && $device->device_id) {
            $detail = DevicePreferences::find()
                ->where(['device_id' => $device->device_id])
                ->andWhere(['project' => $device->project])
                ->andWhere(['title' => $key])
                ->one();

            return $detail->value ?? null;
        }
        return null;
    }
}
