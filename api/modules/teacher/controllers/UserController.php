<?php
/**
 * Created by PhpStorm.
 * User: myounus
 * Date: 2020-06-15
 * Time: 13:48
 */

namespace api\modules\teacher\controllers;

use common\libraries\CustomWidgets;
use common\models\AnnouncementItems;
use common\models\Grade;
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

    public function actionIndex()
    {
        print_r(Yii::t('app', 'At your service'));
    }

    public function actionUploadImages() {
        $data = [
            'model' => Yii::$app->request->post('model', null),
            'model_id' => Yii::$app->request->post('model_id', null),
            'current_image_url' => Yii::$app->request->post('current_image_url', null),
        ];
        return Image::uploadImages($data['model'], $data['model_id'], $data['current_image_url'], 'uploads/user/');
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

    public function actionHomepageAccess()
    {
        $user = User::findById();

        if (empty($user)) {
            return CustomWidgets::returnFail('user not found');
        }

        $data = [];
        $ha = $user->getUserAttributes()
            ->andWhere(['key' => 'homepage_access'])
            ->one();

        if (!empty($ha)) {
            $data = explode(',', $ha->value);
        }

//        $data = ['announcement', 'attendance'];
        return CustomWidgets::returnSuccess($data);
    }

    public function actionGrades()
    {
        $user = User::findById(false);

        $data = [];
        foreach ($user->gradeTeachers as $gradeTeacher) {
            $data[] = $gradeTeacher->grade->toBasicJson();
        }

        return CustomWidgets::returnSuccess($data);
    }

    public function actionStudents()
    {
        $grade = User::getCurrentGrade();

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $data = [];
        foreach ($grade->students as $student) {
            if ($student->status == 'active') {
                $data[] = $student->toBasicJson();
            }
        }

        return CustomWidgets::returnSuccess($data);
    }

    public function actionStudent()
    {
        $grade = User::getCurrentGrade();

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        /**
         * @var Student $student
         */
        $student = $grade->getStudents()
            ->andWhere(['id' => $_POST['student_id']])
            ->one();

        if (empty($student)) {
            return CustomWidgets::returnFail('Student not found');
        }

        return CustomWidgets::returnSuccess($student->toDetailedJson());
    }

    public function actionAnnouncements()
    {
        $grade = User::getCurrentGrade();
        $type = Yii::$app->request->post('type', 'announcement'); //announcement, event

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $studentsIds = $grade->getStudents()->select('id')->column();

        /**
         * @var AnnouncementItems[] $announcementItems
         */
        $announcementItems = AnnouncementItems::find()
            ->where(['in', 'student_id', $studentsIds])
            ->groupBy(['announcement_id'])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $data = [];
        foreach ($announcementItems as $item) {
            if ($item->announcement->type != $type) continue;
            if ($item->announcement->grade_id != $grade->id) continue;
            $an = $item->announcement->toJson();

            $students = [];
            foreach ($item->announcement->announcementItems as $ai) {
                $students[] = $ai->student->toBasicJson();
            }
            $an['students'] = $students;
            $data[$item->announcement->time][] = $an;
        }

        return CustomWidgets::returnSuccess($data);
    }

}