<?php

namespace backend\controllers;

use common\libraries\CustomWidgets;
use common\models\Availability;
use common\models\Grade;
use common\models\GradeRatio;
use common\models\GradeTeacher;
use common\models\GradeTeacherSchedule;
use common\models\Student;
use common\models\StudentSchedule;
use common\models\StudentSearch;
use common\models\User;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class AvailabilityController extends BaseController
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionShowCalculator($school_id, $return_partial = false)
    {
        $model = new Availability(); // Adjust to your actual model

        if ($return_partial) {
            return $this->renderAjax('/user/view/_availability_calculator', [
                'model' => $model,
                'school_id' => $school_id,
                'timeSlots' => $this->getTimeSlots() // Helper method for time slots
            ]);
        }

        return $this->render('_availability_calculator', [
            'model' => $model,
            'school_id' => $school_id,
            'timeSlots' => $this->getTimeSlots() // Helper method for time slots
        ]);
    }

    // Helper method to provide time slots for form display
    protected function getTimeSlots()
    {
        return [
            '6am-7am'  => '6:00 AM - 7:00 AM',
            '7am-8am'  => '7:00 AM - 8:00 AM',
            '8am-9am'  => '8:00 AM - 9:00 AM',
            '9am-10am' => '9:00 AM - 10:00 AM',
            '10am-11am'=> '10:00 AM - 11:00 AM',
            '11am-12pm'=> '11:00 AM - 12:00 PM',

            '12pm-1pm' => '12:00 PM - 1:00 PM',
            '1pm-2pm'  => '1:00 PM - 2:00 PM',
            '2pm-3pm'  => '2:00 PM - 3:00 PM',
            '3pm-4pm'  => '3:00 PM - 4:00 PM',

            '4pm-5pm'  => '4:00 PM - 5:00 PM',
            '5pm-6pm'  => '5:00 PM - 6:00 PM',
            '6pm-7pm'  => '6:00 PM - 7:00 PM',
            '7pm-8pm'  => '7:00 PM - 8:00 PM',

            '8pm-9pm'  => '8:00 PM - 9:00 PM',
            '9pm-10pm' => '9:00 PM - 10:00 PM',
            '10pm-11pm'=> '10:00 PM - 11:00 PM',
            '11pm-12am'=> '11:00 PM - 12:00 AM',

            '12am-1am' => '12:00 AM - 1:00 AM',
            '1am-2am'  => '1:00 AM - 2:00 AM',
            '2am-3am'  => '2:00 AM - 3:00 AM',
            '3am-4am'  => '3:00 AM - 4:00 AM',
            '4am-5am'  => '4:00 AM - 5:00 AM',
            '5am-6am'  => '5:00 AM - 6:00 AM',
        ];
    }


    public function actionCheckAvailability()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Retrieve form data
        $gradeId = $_REQUEST['Availability']['grade_id'] ?? 0;
        $schoolId = $_REQUEST['Availability']['school_id'] ?? 0;
        $startDate = $_REQUEST['Availability']['start_date'] ?? null;
        $endDate = $_REQUEST['Availability']['end_date'] ?? null;

        if (!$gradeId || !$schoolId || !$startDate || !$endDate) {
            return ['success' => false, 'message' => 'Invalid parameters.'];
        }

        // Convert dates to DateTime objects
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $end->modify('+1 day'); // Include end date in the range

        // Fetch the grade ratio to determine the capacity
        $gradeRatio = GradeRatio::findOne(['grade_id' => $gradeId]);
        if (!$gradeRatio) {
            return ['success' => false, 'message' => 'Grade ratio not found.'];
        }

        // Calculate max students based on the ratio
        $teacherCount = GradeTeacher::find()->where(['grade_id' => $gradeId, 'school_id' => $schoolId])->count();
        $maxStudents = $teacherCount * ($gradeRatio->student_ratio / $gradeRatio->teacher_ratio);

        // Initialize response data
        $availabilityData = [];

        // Iterate through each day in the range
        while ($start < $end) {
            $currentDate = $start->format('Y-m-d');
            $dayOfWeek = strtolower($start->format('l')); // e.g., 'monday', 'tuesday', etc.

            // Fetch teacher schedules for this grade and day
            $teacherSchedules = GradeTeacherSchedule::find()
                ->where([
                    'grade_id' => $gradeId,
                    'day_of_week' => $dayOfWeek,
                ])
                ->andWhere(['<=', 'start_date', $currentDate])
                ->andWhere(['>=', 'end_date', $currentDate])
                ->all();

            // Fetch student schedules for this grade and day
            $studentSchedules = StudentSchedule::find()
                ->where([
                    'grade_id' => $gradeId,
                    'day_of_week' => $dayOfWeek,
                ])
                ->andWhere(['<=', 'start_date', $currentDate])
                ->andWhere(['>=', 'end_date', $currentDate])
                ->all();

            // Initialize day availability if not already set
            if (!isset($availabilityData[$currentDate])) {
                $availabilityData[$currentDate] = [];
            }

            // Process each teacher time slot for this day
            foreach ($teacherSchedules as $teacherSchedule) {
                $slot = date('ga', strtotime($teacherSchedule->start_time)) . '-' . date('ga', strtotime($teacherSchedule->end_time));

                // Initialize slot data
                if (!isset($availabilityData[$currentDate][$slot])) {
                    $availabilityData[$currentDate][$slot] = [
                        'total_capacity' => $maxStudents,
                        'booked_students' => 0,
                        'available_slots' => $maxStudents,
                    ];
                }
            }

            // Deduct booked student slots
            foreach ($studentSchedules as $studentSchedule) {
                $slot = date('ga', strtotime($studentSchedule->start_time)) . '-' . date('ga', strtotime($studentSchedule->end_time));
                if (isset($availabilityData[$currentDate][$slot])) {
                    $availabilityData[$currentDate][$slot]['booked_students']++;
                    $availabilityData[$currentDate][$slot]['available_slots'] = max(0, $availabilityData[$currentDate][$slot]['total_capacity'] - $availabilityData[$currentDate][$slot]['booked_students']);
                }
            }

            // Move to the next day in the range
            $start->modify('+1 day');
        }

        return [
            'success' => true,
            'data' => $availabilityData,
        ];
    }


// Helper function to calculate availability
    private function calculateAvailability($teacherSchedules, $studentSchedules, $maxStudents)
    {
        $availability = [];
        $dayNames = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($dayNames as $day) {
            $availability[$day] = [];

            // Group teacher schedules by day
            foreach ($teacherSchedules as $teacherSchedule) {
                if ($teacherSchedule->day_of_week === $day) {
                    $slot = date('ga', strtotime($teacherSchedule->start_time)) . '-' . date('ga', strtotime($teacherSchedule->end_time));
                    $availability[$day][$slot] = [
                        'total_capacity' => $maxStudents,
                        'booked_students' => 0,
                        'available_slots' => $maxStudents,
                    ];
                }
            }

            // Deduct booked student slots
            foreach ($studentSchedules as $studentSchedule) {
                if ($studentSchedule->day_of_week === $day) {
                    $slot = date('ga', strtotime($studentSchedule->start_time)) . '-' . date('ga', strtotime($studentSchedule->end_time));
                    if (isset($availability[$day][$slot])) {
                        $availability[$day][$slot]['booked_students']++;
                        $availability[$day][$slot]['available_slots'] = max(0, $availability[$day][$slot]['total_capacity'] - $availability[$day][$slot]['booked_students']);
                    }
                }
            }
        }

        return $availability;
    }
}
