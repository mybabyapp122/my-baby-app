<?php
/**
 * Created by PhpStorm.
 * User: myounus
 * Date: 2020-06-15
 * Time: 13:48
 */

namespace api\modules\teacher\controllers;

use common\libraries\CustomWidgets;
use common\models\Announcement;
use common\models\AnnouncementItems;
use common\models\Attendance;
use common\models\Grade;
use common\models\Image;
use common\models\Student;
use common\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\base\Security;
use yii\web\UploadedFile;

class FormController extends BaseController
{
    public $modelClass = 'common\models\User';

    public function beforeAction($action)
    {
        $lang = Yii::$app->request->post('lang', 'ar');
        Yii::$app->language = $lang;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        print_r(Yii::t('app', 'At your service'));
    }

    public function actionSubjects()
    {
        $list = [
            "drawing",
            "painting",
            "crafts",
            "music",
            "dancing",
            "storytelling",
            "basic_math",
            "reading",
            "writing",
            "science_experiments",
            "animal_studies",
            "shapes_and_colors",
            "nature_walks",
            "games_and_puzzles",
            "yoga_for_kids",
            "moral_education",
            "social_skills",
            "gardening",
            "rhymes_and_poems",
            "cooking_simple_recipes"
        ];
        return CustomWidgets::returnSuccess($list, 'Fetched');
    }

    public function actionResult()
    {
        $grade = User::getCurrentGrade();

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $user = User::findById();
        $data['Announcement'] = Yii::$app->request->post();
        $ann = new Announcement();
        $ann->load($data);
        $ann->title = $data['Announcement']['subject'] ?? '';
        $ann->body = $data['Announcement']['percentage'] ?? 0;
        $ann->type = 'result';
        $ann->time = $data['Announcement']['date'] ?? NULL;
        $ann->grade_id = $grade->id;
        $ann->user_id = $user->id;

        if (!$ann->save()) {
            return CustomWidgets::returnFail('An error occurred', $ann->getErrors());
        }

        $students = json_decode($data['Announcement']['students']);
        foreach ($students as $student) {
            $anItem = new AnnouncementItems();
            $anItem->announcement_id = $ann->id;
            $anItem->student_id = $student;
            $anItem->save();
        }

        return CustomWidgets::returnSuccess($data, Yii::t('app', '{event_type} created successfully!', ['event_type' => ucfirst($ann->type)]));
    }

    public function actionAnnouncement()
    {
        $grade = User::getCurrentGrade();

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $user = User::findById();
        $data['Announcement'] = Yii::$app->request->post();
        $ann = new Announcement();
        $ann->load($data);
        $ann->grade_id = $grade->id;
        $ann->user_id = $user->id;

        if (!$ann->save()) {
            return CustomWidgets::returnFail('An error occurred', $ann->getErrors());
        }

        $students = json_decode($data['Announcement']['students']);
        foreach ($students as $student) {
            $anItem = new AnnouncementItems();
            $anItem->announcement_id = $ann->id;
            $anItem->student_id = $student;
            $anItem->save();
        }

        return CustomWidgets::returnSuccess($data, Yii::t('app', '{event_type} created successfully!', ['event_type' => Yii::t('app', ucfirst($ann->type))]));
    }

    public function actionViewAttendance() {
        $grade = User::getCurrentGrade();
        $date = date('Y-m-d');

        if (!empty($_POST['time_in'])) {
            $date = date('Y-m-d', strtotime($_POST['time_in']));
        }

        /**
         * @var Student $student
         */
        $student = $grade->getStudents()
            ->andWhere(['id' => $_POST['student_id'] ?? 0])
            ->one();


        if (!isset($student)) {
            return CustomWidgets::returnFail('student not found');
        }

        $model = $student->getAttendances()
            ->andWhere(['DATE(time_in)' => $date])
            ->andWhere(['grade_id' => $grade->id])
            ->one();

        if (!isset($model)) {
            return CustomWidgets::returnFail('attendance not found');
        }

        $data = $model->toArray();
        $data['date'] = $model->time_in;

        return CustomWidgets::returnSuccess($data);
    }

    public function actionAttendance()
    {
        $grade = User::getCurrentGrade();
        $user = User::findById();
        $postData = Yii::$app->request->post();
        $today = $postData['time_in'];
        $date = date('Y-m-d', strtotime($today)); // Extract the date part

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $students = json_decode($postData['students']);

        foreach ($students as $student) {
            $model = Attendance::find()
                ->where(['DATE(time_in)' => $date])
                ->andWhere(['student_id' => $student])
                ->one();

            if (!isset($model)) {
                $model = new Attendance();
            }
            $model->load(['Attendance' => $postData]);
            $model->user_id = $user->id;
            $model->grade_id = $grade->id;

            $model->student_id = $student;
            $model->save(false);
        }

        return CustomWidgets::returnSuccess([], 'Attendance submitted successfully!');
    }

}