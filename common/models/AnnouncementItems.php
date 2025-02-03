<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "announcement_items".
 *
 * @property int $id
 * @property int|null $announcement_id
 * @property int|null $student_id
 *
 * @property Announcement $announcement
 * @property Student $student
 */
class AnnouncementItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'announcement_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['announcement_id', 'student_id'], 'integer'],
            [['announcement_id'], 'exist', 'skipOnError' => true, 'targetClass' => Announcement::class, 'targetAttribute' => ['announcement_id' => 'id']],
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
            'announcement_id' => Yii::t('app', 'Announcement ID'),
            'student_id' => Yii::t('app', 'Student ID'),
        ];
    }

    /**
     * Gets query for [[Announcement]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncement()
    {
        return $this->hasOne(Announcement::class, ['id' => 'announcement_id']);
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
}
