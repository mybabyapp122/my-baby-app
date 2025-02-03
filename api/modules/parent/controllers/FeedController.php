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
use common\models\AnnouncementItems;
use common\models\Feed;
use common\models\FeedComments;
use common\models\Grade;
use common\models\Image;
use common\models\Student;
use common\models\User;
use Yii;
use yii\base\DynamicModel;
use yii\base\Security;
use yii\web\UploadedFile;

class FeedController extends BaseController
{
    public $modelClass = 'common\models\User';

    public function beforeAction($action)
    {
        $lang = Yii::$app->request->post('lang', 'ar');
        Yii::$app->language = $lang;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $user = User::findById();
        $gradeId = $user->selectedStudent->grade_id;

        $feeds = Feed::find()
            ->where(['status' => 'active'])
            ->andWhere(['grade_id' => $gradeId])
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $data = [];
        foreach ($feeds as $feed) {
            $data[] = $feed->toDetailedJson();
        }
        return CustomWidgets::returnSuccess($data);
    }

    public function actionAddComment() {
        $user = User::findById();

        $newComment = new FeedComments();
        $newComment->user_id = $user->id;
        $newComment->student_id = $_POST['student_id'] ?? null;
        $newComment->feed_id = $_POST['id'];
        $newComment->comment = $_POST['comment'];
        if (!$newComment->save()) {
            return CustomWidgets::returnFail('Error', $newComment->getErrors());
        }

        return CustomWidgets::returnSuccess($newComment, 'Comment posted successfully');
    }

    public function actionLikePost() {
        $user = User::findById();

        /**
         * @var Feed|null $feed;
         */
        $feed = Feed::find()
            ->where((['id' => $_POST['id'] ?? 0]))
            ->one();

        if (!isset($feed)) {
            return CustomWidgets::returnFail('cannot find');
        }

        return CustomWidgets::returnSuccess($feed->toggleLike($_POST['student_id'] ?? null));
    }

    public function actionDeletePost() {
        $user = User::findById();

        /**
         * @var Feed|null $feed;
         */
        $feed = $user->getFeeds()
            ->andWhere((['id' => $_POST['id'] ?? 0]))
            ->one();

        if (!isset($feed)) {
            return CustomWidgets::returnFail('cannot find');
        }

        $feed->status = 'deleted';
        $feed->save(false);
        return CustomWidgets::returnSuccess([], Yii::t('app', 'Post deleted successfully'));
    }

}