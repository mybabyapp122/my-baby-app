<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade_teacher".
 *
 * @property int $id
 * @property int $school_id
 * @property int $grade_id
 * @property int $teacher_id
 *
 * @property Grade $grade
 * @property User $school
 * @property User $teacher
 */
class GradeTeacher extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grade_teacher';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'grade_id', 'teacher_id'], 'required'],
            [['school_id', 'grade_id', 'teacher_id'], 'integer'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
            [['school_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['school_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['teacher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_id' => 'School ID',
            'grade_id' => 'Grade ID',
            'teacher_id' => 'Teacher ID',
        ];
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
     * Gets query for [[School]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSchool()
    {
        return $this->hasOne(User::class, ['id' => 'school_id']);
    }

    /**
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'teacher_id']);
    }
}
