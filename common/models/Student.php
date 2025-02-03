<?php

namespace common\models;

use Yii;
use DateTime;

/**
 * This is the model class for table "student".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property int|null $grade_id
 * @property string|null $name
 * @property int|null $id_number
 * @property string|null $name_ar
 * @property string|null $dob
 * @property string|null $gender
 * @property string|null $health
 * @property string|null $allergies
 * @property string $status
 * @property string|null $status_ex
 * @property string|null $create_time
 * @property string $update_time
 *
 * @property string $imageUrl
 * @property AnnouncementItems[] $announcementItems
 * @property Attendance[] $attendances
 * @property Grade $grade
 * @property User $parent
 * @property StudentSchedule[] $studentSchedules
 * @property String $shortTitle
 * @property String $age
 */
class Student extends \yii\db\ActiveRecord
{
    const SCENARIO_NEW_STUDENT = 'new_student';
    public $studentSchedules = [];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'grade_id', 'id_number'], 'integer'],
            [['dob', 'health', 'allergies', 'create_time', 'update_time'], 'safe'],
            [['gender'], 'string'],
            [['name', 'name_ar', 'status', 'status_ex'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['parent_id' => 'id']],
            [['grade_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grade::class, 'targetAttribute' => ['grade_id' => 'id']],

            [['id_number', 'grade_id'], 'required', 'on' => self::SCENARIO_NEW_STUDENT], // Required fields for new user

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_NEW_STUDENT] = ['id_number', 'grade_id']; // Fields required for new user
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'grade_id' => Yii::t('app', 'Grade ID'),
            'name' => Yii::t('app', 'Name'),
            'id_number' => Yii::t('app', 'Id Number'),
            'name_ar' => Yii::t('app', 'Name Ar'),
            'dob' => Yii::t('app', 'DOB'),
            'gender' => Yii::t('app', 'Gender'),
            'health' => Yii::t('app', 'Health'),
            'allergies' => Yii::t('app', 'Allergies'),
            'status' => Yii::t('app', 'Status'),
            'status_ex' => Yii::t('app', 'Status Ex'),
            'create_time' => Yii::t('app', 'Create Time'),
            'update_time' => Yii::t('app', 'Update Time'),
        ];
    }

    public function getImageUrl() {
        $img = Image::readImage('student', $this->id);
        if ($img['success']) {
            return $img['data'][0];
        }
        return '';
    }

    /**
     * Gets query for [[AnnouncementItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncementItems()
    {
        return $this->hasMany(AnnouncementItems::class, ['student_id' => 'id']);
    }

    /**
     * Gets query for [[Attendances]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAttendances()
    {
        return $this->hasMany(Attendance::class, ['student_id' => 'id']);
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
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(User::class, ['id' => 'parent_id']);
    }

    /**
     * Gets query for [[StudentSchedules]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudentSchedules()
    {
        return $this->hasMany(StudentSchedule::class, ['student_id' => 'id']);
    }

//    function getShortTitle() {
//        $names = explode(' ', trim($this->name));
//
//        // Get the first character of the first and last names
//        $initials = strtoupper($names[0][0] . (count($names) > 1 ? $names[count($names) - 1][0] : ''));
//
//        return $initials;
//    }

    function getShortTitle() {
        // Ensure the name is not empty or null
        if (empty($this->name)) {
            return ''; // Return an empty string or a default value
        }

        // Split the name into parts
        $names = preg_split('/\s+/u', trim($this->name)); // Use preg_split with UTF-8 support

        // Validate the name array has at least one part
        if (empty($names) || empty($names[0])) {
            return ''; // Return an empty string or a default value
        }

        // Get the initials using multibyte functions for Arabic support
        $firstInitial = mb_strtoupper(mb_substr($names[0], 0, 1, 'UTF-8'), 'UTF-8');
        $lastInitial = (count($names) > 1 && !empty($names[count($names) - 1]))
            ? mb_strtoupper(mb_substr($names[count($names) - 1], 0, 1, 'UTF-8'), 'UTF-8')
            : '';

        // Check if the name contains Arabic characters
        $isArabic = preg_match('/\p{Arabic}/u', $this->name);

        // Combine initials
        $initials = $isArabic ? $firstInitial . ' ' . $lastInitial : $firstInitial . $lastInitial;


        return $initials;
    }

    function getAge() {
        if (empty($this->dob)) return '';
        $dateString = $this->dob;
        $birthDate = new DateTime($dateString);
        $today = new DateTime(); // Current date

        $age = $today->diff($birthDate)->y; // Get the difference in years

        return 'Age: ' . $age; // Output the age
    }

    function toBasicJson() {
        return [
            'id' => $this->id,
            'title' => $this->name,
            'id_number' => (string) $this->id_number ?? '',
            'school_id' => (isset($this->grade) && isset($this->grade->school->id)) ? $this->grade->school->id : '',
            'school_name' => (isset($this->grade) && isset($this->grade->school)) ? $this->grade->school->name : '',
            'short_title' => $this->shortTitle,
            'image_url' => $this->imageUrl,
            'status' => $this->status,
        ];
    }

    function toDetailedJson() {
        return [
            'subtitle' => (string)$this->age ?? '',
            'mobile' => $this->parent->mobile,
            'whatsapp' => $this->parent->mobile,
            'health' => $this->health ?? [],
            'allergies' => $this->allergies ?? [],
        ] + $this->toBasicJson();
    }

    public static function scheduleDetails($studentId, $start_date = null, $end_date = null)
    {
        if (!empty($start_date)) $start_date = new \DateTime($start_date);
        if (!empty($end_date)) $end_date = new \DateTime($end_date);

        $student = Student::findOne($studentId);
        // Fetch all records for the given student ID
        $schedules = StudentSchedule::find()
            ->where(['student_id' => $studentId])
            ->andWhere(['grade_id' => $student->grade_id])
            ->all();

        $totalHours = 0;
        $uniqueDays = [];
        $startingDate = null;
        $endingDate = null;

        if (!empty($schedules)) {
            foreach ($schedules as $schedule) {
                // Convert start and end times to DateTime objects
                $startTime = new \DateTime($schedule->start_time);
                $endTime = new \DateTime($schedule->end_time);

                // Calculate the daily duration in hours
                $interval = $startTime->diff($endTime);
                $hoursPerDay = $interval->h + ($interval->i / 60);

                // Calculate the number of days the schedule spans
                $startDate = $start_date ?? new \DateTime($schedule->start_date);
                $endDate = $end_date ?? new \DateTime($schedule->end_date);

                // Update starting and ending dates
                if (is_null($startingDate) || $startDate < $startingDate) {
                    $startingDate = $startDate;
                }
                if (is_null($endingDate) || $endDate > $endingDate) {
                    $endingDate = $endDate;
                }

                // Collect unique days between start_date and end_date
                $period = new \DatePeriod(
                    $startDate,
                    new \DateInterval('P1D'),
                    (clone $endDate)->modify('+1 day') // Include the end date
                );

                foreach ($period as $day) {
                    $uniqueDays[$day->format('Y-m-d')] = true;
                }

                // Accumulate total hours
                $daysDifference = $startDate->diff($endDate)->days + 1;
                $totalHours += $hoursPerDay * $daysDifference;
            }
        }

        return [
            'hours' => $totalHours,
            'days' => count($uniqueDays),
            'starting_date' => $startingDate ? $startingDate->format('Y-m-d') : null,
            'ending_date' => $endingDate ? $endingDate->format('Y-m-d') : null,
        ];
    }


    public function loadStudentSchedules($selectedGrades)
    {
        $this->studentSchedules = [];
        foreach ($selectedGrades as $gradeId) {
            // Fetch all schedules for the given grade and student
            $schedules = StudentSchedule::find()->where([
                'student_id' => $this->id,
                'grade_id' => $gradeId
            ])->all();

            // Initialize an empty schedule if none exists
            $scheduleModel = new StudentSchedule();
            $scheduleModel->grade_id = $gradeId;
            $scheduleModel->student_id = $this->id;
            $scheduleModel->schedule = []; // Initialize schedule array for each day

            // Populate the schedule array with time slots for each day
            foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day) {
                $scheduleModel->schedule[$day] = ['start_time' => [], 'end_time' => []];
            }

            // Assign saved start and end times to the schedule array by day
            foreach ($schedules as $schedule) {
                $day = $schedule->day_of_week;

                // Format start and end times to match '6am-7am' format
                $timeSlot = date('ga', strtotime($schedule->start_time)) . '-' . date('ga', strtotime($schedule->end_time));
                $scheduleModel->schedule[$day]['start_time'][] = $timeSlot;

                if (empty($scheduleModel->start_date) && empty($scheduleModel->end_date)) {
                    $scheduleModel->start_date = date('Y-m-d', strtotime($schedule->start_date));
                    $scheduleModel->end_date = date('Y-m-d', strtotime($schedule->end_date));
                }
            }

            $this->studentSchedules[$gradeId] = $scheduleModel;
        }
    }

}
