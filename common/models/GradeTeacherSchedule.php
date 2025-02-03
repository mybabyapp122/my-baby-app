<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "grade_teacher_schedule".
 *
 * @property int $id
 * @property int $grade_id
 * @property int $teacher_id
 * @property string $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property string $start_date
 * @property string $end_date
 *
 * @property Grade $grade
 * @property User $teacher
 */
class GradeTeacherSchedule extends \yii\db\ActiveRecord
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
        return 'grade_teacher_schedule';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grade_id', 'teacher_id', 'day_of_week', 'start_time', 'end_time', 'start_date', 'end_date'], 'required'],
            [['grade_id', 'teacher_id'], 'integer'],
            [['day_of_week'], 'string'],
            [['start_time', 'end_time', 'start_date', 'end_date'], 'safe'],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],
            [['teacher_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['teacher_id' => 'id']],
            [['start_time'], 'validateTimeSlots'],
        ];
    }

    public function validateTimeSlots($attribute, $params)
    {
        // If a day of the week is provided, ensure at least one time slot is selected
        if (!empty($this->day_of_week) && (empty($this->start_time) || empty($this->end_time))) {
            $this->addError($attribute, 'At least one time slot must be selected for each selected day.');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'teacher_id' => Yii::t('app', 'Teacher ID'),
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
     * Gets query for [[Teacher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTeacher()
    {
        return $this->hasOne(User::class, ['id' => 'teacher_id']);
    }
}
