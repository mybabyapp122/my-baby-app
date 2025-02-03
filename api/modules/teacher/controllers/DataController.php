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

class DataController extends BaseController
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

    public function actionAttendances()
    {
        $grade = User::getCurrentGrade();

        if (empty($grade)) {
            return CustomWidgets::returnFail('Grade not found');
        }

        $studentsIds = $grade->getStudents()->select(['id'])->column();

        // Fetch attendance dates and group by date
        $allAttendances = Attendance::find()
            ->select(['DATE(time_in) AS attendance_date'])
            ->andWhere(['grade_id' => $grade->id])
            ->andWhere(['in', 'student_id', $studentsIds])
            ->groupBy(['attendance_date'])
            ->orderBy(['attendance_date' => SORT_DESC])
            ->column();

        // Prepend today's date to the list
        array_unshift($allAttendances, date('Y-m-d'));
        $allAttendances = array_values(array_unique($allAttendances));

        $data = [];
        foreach ($allAttendances as $singleDay) {
            $data[] = Attendance::getStats($grade->id, $singleDay, $studentsIds);
        }

        return CustomWidgets::returnSuccess($data);
    }

}