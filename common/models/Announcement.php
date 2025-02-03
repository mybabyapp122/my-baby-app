<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $grade_id
 * @property string|null $title
 * @property string|null $body
 * @property string $type
 * @property string|null $time
 * @property string|null $status
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property AnnouncementItems[] $announcementItems
 * @property Grade $grade
 * @property User $user
 */
class Announcement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'grade_id'], 'integer'],
            [['body', 'type'], 'string'],
            [['time', 'create_time', 'update_time'], 'safe'],
            [['title', 'status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'type' => Yii::t('app', 'Type'),
            'time' => Yii::t('app', 'Time'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[AnnouncementItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncementItems()
    {
        return $this->hasMany(AnnouncementItems::class, ['announcement_id' => 'id']);
    }

    /**
     * Gets query for [[Grade]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrade()
    {
        return $this->hasOne(Grade::class, ['id' => 'grade_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    function toJson() {
        $data = [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->body,
            'type' => $this->type,
            'date' => $this->time,
            'posted_by' => $this->user->name,
        ];

        return $data;
    }
}
