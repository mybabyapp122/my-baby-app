<?php
namespace api\controllers;

use common\models\GroupMembers;
use common\models\Groups;
use common\models\Messages;
use Yii;
use common\libraries\CustomWidgets;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;

class ChatController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];
        return $behaviors;
    }

    public function beforeAction($action) {
        $lang = Yii::$app->request->post('lang', 'ar');
        Yii::$app->language = $lang;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        return 'At your service. Just type the action name in your url and I\'ll fetch it for you!';
    }

    public function actionGroups()
    {
        $groups = Groups::find()->where(['school_id' => $_POST['school_id']])->all();
        $data = [];
        $currentUserId = $_POST['user_id'];

        foreach ($groups as $group) {
            $isMember = GroupMembers::find()
                ->where(['group_id' => $group->id])
                ->andWhere(['user_id' => $currentUserId])
                ->one();

            // Check if the current user is in the group's members
//            $isMember = $group->getGroupMembers()
//                ->where(['user_id' => $currentUserId])
//                ->exists();

            if ($isMember) {
                $data[] = [
                    'id' => $group->id,
                    'name' => $group->name,
                    'last_mesg' => Messages::getLastMesg($group->id),
                ];
            }
        }
        return CustomWidgets::returnSuccess($data);
    }

    public function actionMessages()
    {
        $school_id = $_POST['school_id'];
        $group_id = $_POST['group_id'];
        $loaded_message_ids = $_POST['loaded_message_ids'] ?? []; // IDs of already loaded messages
        $fetch_new_only = $_POST['fetch_new_only'] ?? false;

        $group = Groups::find()
            ->where(['school_id' => $school_id])
            ->andWhere(['id' => $group_id])
            ->one();
        $alreadyMembers = ArrayHelper::map($group->groupMembers, 'user_id', 'user_id');

//        $messages = Messages::find()
//            ->where(['group_id' => $group_id])
//            ->andWhere(['IN', 'sender_id', $alreadyMembers])
//            ->orderBy(['id' => SORT_DESC])
//            ->all();

        // Build the query
        $query = Messages::find()
            ->where(['group_id' => $group_id])
            ->andWhere(['IN', 'sender_id', $alreadyMembers]);

        // Exclude already loaded messages if `fetch_new_only` is true
        if ($fetch_new_only && !empty($loaded_message_ids)) {
            $query->andWhere(['NOT IN', 'id', $loaded_message_ids]);
        }

        // Sort messages by create_time DESC (newest first)
        $query->orderBy(['create_time' => SORT_DESC]);
        // Execute the query and prepare the response
        $messages = $query->all();

        $data = [];
        foreach ($messages as $message) {
                $data[] = [
                    'id' => $message->id,
                    'group_id' => $message->group_id,
                    'sender_id' => $message->sender_id,
                    'message' => $message->message,
                    'create_time' => $message->create_time,
                    'username' => $message->sender->username ?? 'unknown',
                    'role' => $message->sender->role ?? 'School',
                ];
        }

        return CustomWidgets::returnSuccess($data, "Fetched");
    }




    public function actionSendMessage()
    {
//        $school_id = $_POST['school_id'];
        $group_id = $_POST['group_id'];
        $sender_id = $_POST['sender_id'];
        $mesg = $_POST['mesg'];

        //Verify if sender is allowed or not
        $groupMembers = GroupMembers::find()
            ->where(['group_id' => $group_id])
            ->andWhere(['user_id' => $sender_id])
            ->one();

        if (empty($groupMembers)) {
            return CustomWidgets::returnFail(Yii::t('app', 'You are not allowed to send messages in this group'));
        }

        $model = new Messages();
        $model->message = $mesg;
        $model->group_id = $group_id;
        $model->sender_id = $sender_id;
        $model->save(false);

        return CustomWidgets::returnSuccess($model);
    }







    public function actionCreateGroup()
    {
        $group = new Groups();
        $group->name = \Yii::$app->request->post('name');
        if ($group->save()) {
            return ['status' => 'success', 'group' => $group];
        }
        return ['status' => 'error', 'errors' => $group->errors];
    }

    public function actionAddMember($groupId)
    {
        $member = new GroupMembers();
        $member->group_id = $groupId;
        $member->user_id = \Yii::$app->request->post('user_id');
        if ($member->save()) {
            return ['status' => 'success', 'member' => $member];
        }
        return ['status' => 'error', 'errors' => $member->errors];
    }

}
