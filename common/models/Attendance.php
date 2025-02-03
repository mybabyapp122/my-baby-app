<?php

namespace common\models;

use Yii;
use DateTime;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $student_id
 * @property int|null $grade_id
 * @property string|null $time_in
 * @property string|null $time_out
 * @property string|null $lunch
 * @property int|null $nap minutes
 * @property int|null $bathroom_breaks
 * @property string|null $status
 * @property string|null $create_time
 * @property string|null $update_time
 *
 * @property Grade $grade
 * @property Student $student
 * @property User $user
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'student_id', 'grade_id', 'nap', 'bathroom_breaks'], 'integer'],
            [['time_in', 'time_out', 'create_time', 'update_time'], 'safe'],
            [['lunch', 'status'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Student::class, 'targetAttribute' => ['student_id' => 'id']],
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
            'student_id' => Yii::t('app', 'Student ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'time_in' => Yii::t('app', 'Time In'),
            'time_out' => Yii::t('app', 'Time Out'),
            'lunch' => Yii::t('app', 'Lunch'),
            'nap' => Yii::t('app', 'Nap'),
            'bathroom_breaks' => Yii::t('app', 'Bathroom Breaks'),
            'status' => Yii::t('app', 'Status'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
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

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    static function getStats($gradeId = null, $date = null, $studentsPool = null) {
        if ($date == null) {
            $date = date('Y-m-d');
        } else {
            $date = date('Y-m-d', strtotime($date));
        }

        $model = Attendance::find()->where(['DATE(time_in)' => $date])->andWhere(['grade_id' => $gradeId]);
        $present = (clone $model)->andWhere(['status' => 'present'])->all();
        $absent = (clone $model)->andWhere(['status' => 'absent'])->all();
//        if ($studentsPool == null) {
//            $studentsPool = (clone $model)->select(['student_id'])->groupBy(['student_id'])->column();
//        }

        $result = [
            'date' => date('Y-m-d h:m:s', strtotime($date)),
            'unassigned' => [],
            'present' => [],
            'absent' => [],
        ];

        // Get IDs of present and absent students
        $presentIds = array_column($present, 'student_id');
        $absentIds = array_column($absent, 'student_id');

        foreach ($studentsPool as $studentId) {
            if (in_array($studentId, $presentIds)) {
                $result['present'][] = $studentId; // Add to present
            } elseif (in_array($studentId, $absentIds)) {
                $result['absent'][] = $studentId; // Add to absent
            } else {
                $result['unassigned'][] = $studentId; // Add to unassigned
            }
        }

        return $result;
    }

    function parentOverviewJson() {
        $data = [
            'id' => $this->id,
            'time_in' => $this->time_in,
            'time_out' => $this->time_out ?? '',
            'lunch' => $this->lunch ?? '',
            'nap' => $this->nap ?? '',
            'bathroom_breaks' => $this->bathroom_breaks ?? '',
            'status' => $this->status,
        ];

        if (!empty($this->time_in) && !empty($this->time_out)) {
            // Create DateTime objects
            $dateTimeIn = new DateTime($this->time_in);
            $dateTimeOut = new DateTime($this->time_out);

            // Calculate the difference
            $interval = $dateTimeIn->diff($dateTimeOut);

            // Get the difference in hours
            $hoursDifference = $interval->h + ($interval->days * 24); // Total hours, including days
            $minutesDifference = $interval->i; // Get minutes if needed

            $output = "{$hoursDifference} hours";

            if ($minutesDifference > 10) {
                $output = "{$hoursDifference} hours {$minutesDifference} mins";
            }

            $data['duration'] = $output;
        }

        return $data;
    }
}
