<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feed_comments".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $student_id
 * @property int|null $feed_id
 * @property string|null $comment
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property Feed $feed
 * @property Student $student
 * @property User $user
 */
class FeedComments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feed_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'feed_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['comment'], 'string', 'max' => 500],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['feed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Feed::class, 'targetAttribute' => ['feed_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'feed_id' => Yii::t('app', 'Feed ID'),
            'comment' => Yii::t('app', 'Comment'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    /**
     * Gets query for [[Feed]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFeed()
    {
        return $this->hasOne(Feed::class, ['id' => 'feed_id']);
    }

    /**
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
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

    function toDetailedJson() {
        return [
            'id' => $this->id,
            'image_url' => $this->student ? $this->student->imageUrl : $this->user->imageUrl,
            'title' => $this->student ? $this->student->name : $this->user->name,
            'comment' => $this->comment,
            'create_time' => $this->update_time,
        ];
    }
}
