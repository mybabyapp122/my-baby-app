<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "student_schedule".
 *
 * @property int $id
 * @property int $student_id
 * @property int $grade_id
 * @property string $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property string $start_date
 * @property string $end_date
 *
 * @property Grade $grade
 * @property Student $student
 */
class StudentSchedule extends \yii\db\ActiveRecord
{
    public $schedule = [
        'monday' => ['start_time' => null, 'end_time' => null],
        'tuesday' => ['start_time' => null, 'end_time' => null],
        'wednesday' => ['start_time' => null, 'end_time' => null],
        'thursday' => ['start_time' => null, 'end_time' => null],
        'friday' => ['start_time' => null, 'end_time' => null],
        'saturday' => ['start_time' => null, 'end_time' => null],
        'sunday' => ['start_time' => null, 'end_time' => null],
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'grade_id', 'day_of_week', 'start_time', 'end_time', 'end_date'], 'required'],
            [['student_id', 'grade_id'], 'integer'],
            [['day_of_week'], 'string'],
            [['start_time', 'end_time', 'start_date', 'end_date'], 'safe'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'day_of_week' => Yii::t('app', 'Day Of Week'),
            'start_time' => Yii::t('app', 'Start Time'),
            'end_time' => Yii::t('app', 'End Time'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
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
     * Gets query for [[Student]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Student::class, ['id' => 'student_id']);
    }
}
