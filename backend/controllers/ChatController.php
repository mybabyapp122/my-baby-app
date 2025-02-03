<?php

namespace backend\controllers;

use common\libraries\CustomWidgets;
use common\models\GroupMembers;
use common\models\Groups;
use common\models\GroupsSearch;
use common\models\Messages;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\Response;
use Yii;

/**
 * StudentController implements the CRUD actions for Student model.
 */
class ChatController extends Controller
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

    /**
     * Displays the main group management and chat interface.
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new GroupsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $columns = [
            'id', 'name',
            [
                'attribute' => 'id',
                'label' => Yii::t('app', 'Members'),
                'format' => 'raw', // Enables rendering HTML
                'value' => function ($model) {
                    $html = '';
                    foreach ($model->groupMembers as $member){
                       $html .= '
                                <span class="text-muted">['. ucfirst($member->user->role) .']</span>
                                <strong>'.$member->user->name .'</strong>
                                <span class="text-muted">(@'.strtolower($member->user->username).')</span>
                                <br>
                            ';
                       }

                    return $html;
                },
            ],
        ];

        return $this->renderPartial('index', [
            'title' => 'Chat Groups',
            'update_action' => 'update-group',
            'view_action' => 'view',
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }

    public function actionUpdateGroup() {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $group_id = $_REQUEST['group_id'] ?? $_REQUEST['Groups']['group_id'] ?? 0;
        $school_id = Yii::$app->user->id;

        $model = Groups::find()->where(['id' => $group_id])->andWhere(['school_id' => $school_id])->one();

        if (empty($model)) {
            $model = new Groups();
            $model->school_id = $school_id;
        }

        if ($this->request->isPost && $model->load($this->request->post())) {
            if (Yii::$app->request->isAjax) {
                if ($model->validate() && $model->save(false)) {
                    return [
                        'success' => true,
                        'message' => Yii::t('app', 'Changes saved')
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => Yii::t('app', 'Failed to save'),
                        'error' => $model->getErrors(),
                    ];
                }

            }

            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        return CustomWidgets::returnSuccess([
            'heading' => Yii::t('app', 'Chat Group'),
            'body' => $this->renderAjax('_groups_form', [
                'model' => $model,
            ]),
        ]);
    }

    public function actionAddMember()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user_id = $_POST['user_id'] ?? '';
        $group_id = $_POST['group_id'] ?? '';

        if (empty($user_id) || empty($group_id)) {
            return CustomWidgets::returnFail('Something went wrong', []);
        }

        $model = GroupMembers::find()->where(['group_id' => $group_id])->andWhere(['user_id' => $user_id])->one();
        //If not a member
        if (!$model) {
            $model = new GroupMembers();
            $model->user_id = $user_id;
            $model->group_id = $group_id;
            $model->save();
        }
        return CustomWidgets::returnSuccess($model, 'Success');
    }

    public function actionRemoveMember()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user_id = $_POST['user_id'] ?? '';
        $group_id = $_POST['group_id'] ?? '';

        if (empty($user_id) || empty($group_id)) {
            return CustomWidgets::returnFail('Something went wrong', []);
        }

        $model = GroupMembers::find()->where(['group_id' => $group_id])->andWhere(['user_id' => $user_id])->one();
        //If not a member
        if ($model && $model->delete()) {
            return CustomWidgets::returnSuccess($model, 'Success');
        }
        return CustomWidgets::returnFail('Failed', $model->getErrors());
    }

    public function actionView($group_id)
    {
        $group = Groups::findOne($group_id);
        $model = new Messages();

        $school = User::findById();
        $members = $school->getAssociatedPeople();

        $alreadyMembers = ArrayHelper::map($group->groupMembers, 'user_id', 'user_id');
        $filteredMembers = array_diff($members, $alreadyMembers);
        $filteredMembers = ArrayHelper::map(
            User::find()->where(['id' => $filteredMembers])->andWhere(['status' => 'active'])->all(),
            'id',
            function ($user) {
                return $user->name . ' - ' . ucfirst($user->role); // Concatenate name and role
            }
        );

        if ($group) {
            return $this->render('chat', [
                'group' => $group,
                'model' => $model,
                'filtered_members' => $filteredMembers,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'Group not found');
            return $this->redirect(['index']);
        }
    }

    public function actionSendMessage($group_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new Messages();
        $model->load($_POST);
        $model->group_id = $group_id;
        $model->sender_id = Yii::$app->user->id;
        $model->save(false);

        return CustomWidgets::returnSuccess([], 'sent');
    }

    public function actionLoadMessages($group_id)
    {
        $group = Groups::find()
            ->where(['school_id' => Yii::$app->user->id])
            ->andWhere(['id' => $group_id])
            ->one();

//        $group = Groups::findOne($group_id);
        $alreadyMembers = ArrayHelper::map($group->groupMembers, 'user_id', 'user_id');

        // Fetch messages related to the group, ordering by creation date
        $messages = Messages::find()
            ->where(['group_id' => $group_id])
            ->andWhere(['IN', 'sender_id', $alreadyMembers])
            ->orderBy(['create_time' => SORT_ASC])
            ->all();

        // Render a partial view with the messages, which can be updated via AJAX
        return $this->renderPartial('_messages', [
            'messages' => $messages,
        ]);
    }
}
