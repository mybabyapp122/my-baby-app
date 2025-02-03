<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "preferences".
 *
 * @property int $id
 * @property string|null $project Project name
 * @property string|null $title
 * @property string|null $value
 * @property int|null $status
 * @property string $create_time
 * @property string $update_time
 */
class Preferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preferences';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['project', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project' => Yii::t('app', 'Project'),
            'title' => Yii::t('app', 'Title'),
            'value' => Yii::t('app', 'Value'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public static function readPreference($project, $title)
    {
        $model = Preferences::find()
            ->where(['project' => $project])
            ->andWhere(['title' => $title])
            ->one();

        if (isset($model)) return $model->value;
        return null;
    }
}
