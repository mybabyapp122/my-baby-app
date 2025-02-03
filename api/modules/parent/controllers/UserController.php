<?php
/**
 * Created by PhpStorm.
 * User: myounus
 * Date: 2020-06-15
 * Time: 13:48
 */

namespace api\modules\parent\controllers;

use api\modules\teacher\controllers\BaseController;
use common\libraries\CustomWidgets;
use common\libraries\SmartNSP;
use common\models\AnnouncementItems;
use common\models\Attendance;
use common\models\Grade;
use common\models\GradeTeacher;
use common\models\Image;
use common\models\Student;
use common\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\base\Security;
use yii\web\UploadedFile;

class UserController extends BaseController
{
    public $modelClass = 'common\models\User';

    public function beforeAction($action)
    {
        $lang = Yii::$app->request->post('lang', 'ar');
        Yii::$app->language = $lang;
        return parent::beforeAction($action);
    }

    public function actionUploadImages() {
        $data = [
            'model' => Yii::$app->request->post('model', null),
            'model_id' => Yii::$app->request->post('model_id', null),
            'current_image_url' => Yii::$app->request->post('current_image_url', null),
        ];
        return Image::uploadImages($data['model'], $data['model_id'], $data['current_image_url'], 'uploads/user/');
    }

    public function actionIndex()
    {
        print_r(Yii::t('app', 'At your service'));
    }

    public function actionProfile() {
        $user = User::findById(false);

        $data = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'image_url' => $user->imageUrl,
        ];

        return CustomWidgets::returnSuccess($data);
    }

    public function actionUpdate() {
        $model = User::findById(false);
        $post['User'] = [
            'name' => Yii::$app->request->post('name', $model->name),
            'mobile' => Yii::$app->request->post('mobile', $model->mobile),
        ];

        $model->load($post);
        $model->mobile = ltrim($model->mobile, '0');
        $model->random_username();

        if ($model->name == '') {
            return [
                'success' => false,
                'message' => Yii::t('app', 'Please make sure you enter full name'),
                'status' => 406,
            ];
        }

        $model->removeHiddenCharacters();

        //Profile is completed
        if (!empty($model->name) && !empty($model->mobile)) {
            $model->status = 'active';
            $model->status_ex = NULL;
        }

        if ($model->save()) {
            return CustomWidgets::returnSuccess($model->basicInfoJson(), Yii::t('app', 'User info updated'));
        }

        return CustomWidgets::returnFail($model->getErrors());
    }

    public function actionSetPassword($password = null) {
        $data = ['password' => Yii::$app->request->post('password', $password)];
        $modelData = DynamicModel::validateData($data, [
            [['password'] , 'required'],
        ]);

        if (!$modelData->validate() ) {
            return CustomWidgets::returnFail('Validation failed', $modelData->getErrors());
        }

        $user = User::findById(false);

        $security = new Security;
        $user->password_hash = $security->generatePasswordHash($data['password']);
        $user->status_ex = '';

        if (!$user->save()) {
            return CustomWidgets::returnFail($user->getErrors(), $user->getErrors());
        }
        return CustomWidgets::returnSuccess($user->basicInfoJson(), 'Password updated');
    }

    public function actionStudents()
    {
        $user = User::findById(false);
        $data = [];
        foreach ($user->students as $student) {
            $data[] = $student->toBasicJson();
        }

        return CustomWidgets::returnSuccess($data);
    }

    public function actionStudent()
    {
        $user = User::findById(false);
        $student = $user->selectedStudent;

        if (empty($student)) {
            return CustomWidgets::returnFail('Student not found');
        }

        return CustomWidgets::returnSuccess($student->toDetailedJson());
    }

    public function actionHomepage()
    {
        $user = User::findById();
        $student = $user->selectedStudent;
        $days = [];


        if (!empty($student->attendances)) {
            foreach ($student->attendances as $attendance) {
                $days[CustomWidgets::reformatDate($attendance->time_in)]['attendance'] = $attendance->parentOverviewJson();
            }
        }

        if (!empty($student->announcementItems)) {
            foreach ($student->announcementItems as $ai) {
                $days[CustomWidgets::reformatDate($ai->announcement->time)]['announcement'][] = $ai->announcement->toJson();
            }
        }


        return CustomWidgets::returnSuccess($days);
    }

    function beautifyDuration($durationInMinutes, $lang = 'en') {
        // Handle edge cases for 0 minutes or negative values
        if ($durationInMinutes <= 0) {
            return $lang === 'ar' ? "مدة غير صالحة" : "Invalid duration";
        }

        $hours = floor($durationInMinutes / 60);
        $minutes = $durationInMinutes % 60;

        if ($lang === 'ar') {
            // Arabic translations
            if ($hours > 0 && $minutes > 0) {
                return "$hours ساعة" . " و $minutes دقيقة";
            } elseif ($hours > 0) {
                return "$hours ساعة";
            } elseif ($minutes > 0) {
                if ($minutes == 30) {
                    return "نصف ساعة";
                } else {
                    return "$minutes دقيقة";
                }
            }
        } else {
            // English translations (default)
            if ($hours > 0 && $minutes > 0) {
                return "$hours hour" . ($hours > 1 ? 's' : '') . " $minutes minute" . ($minutes > 1 ? 's' : '');
            } elseif ($hours > 0) {
                return "$hours hour" . ($hours > 1 ? 's' : '');
            } elseif ($minutes > 0) {
                if ($minutes == 30) {
                    return "half hour";
                } else {
                    return "$minutes minute" . ($minutes > 1 ? 's' : '');
                }
            }
        }

        return $lang === 'ar' ? "مدة غير صالحة" : "Invalid duration";
    }

    public function actionNotifySchool() {
        //receives student_id, minutes
        //if minutes == 0 then send notification that I am here

        $data = [
            'student_id' => Yii::$app->request->post('student_id', null),
            'minutes' => Yii::$app->request->post('minutes', 15),
        ];

        $student = Student::find()->where(['id' => $data['student_id']])->one();

        if (empty($student)) {
            return CustomWidgets::returnFail(Yii::t('app', 'Student not found'));
        }
        $grade_teachers = GradeTeacher::find()->where(['grade_id' => $student->grade_id])->all();

        if (!empty($grade_teachers)) {
            foreach ($grade_teachers as $teacher) {
                $title = Yii::t('app', 'Pickup Alert');
                if ($data['minutes'] == 0) {
                    $message = Yii::t('app', '{parent_name} is here to pickup {student_name}', ['parent_name' => $student->parent->name, 'student_name' => $student->name]);
                } else {
                    $lang = $_POST['lang'] ?? 'ar';
                    $duration = $this->beautifyDuration($data['minutes'], $lang);
                    $message = Yii::t('app', '{parent_name} will be here in {duration} to pickup {student_name}', ['parent_name' => $student->parent->name, 'student_name' => $student->name, 'duration' => $duration]);
                }
//                return CustomWidgets::returnSuccess([], $message);

                $notificationService = new SmartNSP();
                $notificationService->sendPush(1);
                $notificationService->createNotification('mybaby',
                    $teacher->teacher_id,
                    $title,
                    $message
                );
            }
        }

        return CustomWidgets::returnSuccess([], Yii::t('app', 'Notification sent!'));
    }

    public function actionViewChild()
    {
        $user = User::findById();
        $student = $user->selectedStudent;

        if (empty($student)) {
            return CustomWidgets::returnFail('Student not found');
        }

        $result = $student->toArray();
        $result['image_url'] = $student->imageUrl;
        return CustomWidgets::returnSuccess($result);
    }

    public function actionUpdateChild()
    {
        $user = User::findById();
        $student = $user->selectedStudent;

        $data = [
            'name' => Yii::$app->request->post('name', $student->name),
            'dob' => Yii::$app->request->post('dob', $student->dob),
        ];

        $student->load(['Student' => $data]);
        $student->health = json_decode($_POST['health'] ?? []);
        $student->allergies = json_decode($_POST['allergies'] ?? []);


        //Profile is completed
        if (!empty($student->name) && !empty($student->id_number)) {
            $student->status = 'active';
            $student->status_ex = NULL;
        }

        if (!$student->save()) {
            return CustomWidgets::returnFail($student->getErrors());
        }

        return CustomWidgets::returnSuccess($student, 'Success');
    }

    public function actionBalances()
    {
        $user = User::findById();
        $sales = [];
        foreach ($user->incomingSales as $sale) {
            $sales[] = $sale->toJson();
        }

        return CustomWidgets::returnSuccess($sales, 'Success');
    }


}