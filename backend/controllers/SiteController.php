<?php

namespace backend\controllers;

use common\models\Announcement;
use common\models\LoginForm;
use common\models\Plan;
use common\models\Sale;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $user = Yii::$app->user->identity;
        if (empty($user)) {
            throw new \Exception("You are not allowed to view this page.");
        }

        if ($user->role == 'school') {
            return $this->render('school-analytics');
        }

        return $this->render('dashboard-analytics');
//        return $this->render('index');
    }

    public function actionGetUpcomingEvents($date = null)
    {
        // Set response format to JSON
        \Yii::$app->response->format = Response::FORMAT_JSON;

        $request = Yii::$app->request;

        // Get today's date
        $today = $date == null ? new \DateTime() : new \DateTime($date);
        $todayStart = $today->format('Y-m-d 00:00:00');
        $todayEnd = $today->format('Y-m-d 23:59:59');

        $school = Yii::$app->user->identity;
        $related_grades = $school->getAssociatedPeople(false,false,false,true);

        // Fetch all appointments for today
        $announcements = Announcement::find()
            ->where(['between', 'time', $todayStart, $todayEnd])
            ->andWhere(['IN', 'grade_id', $related_grades])
            ->all();

        $data = [];
        foreach ($announcements as $announcement) {

            $data[] = [
                'id' => $announcement->grade->shortTitle,
                'type' => ucfirst($announcement->type),
                'title' => ucfirst($announcement->title),
                'body' => $announcement->type == 'result' ? $announcement->body . '%' : ucfirst($announcement->body),
                'created_by' => ucfirst($announcement->user->name),
            ];
        }

        return [
            'success' => true,
            'message' => 'Fetched all events for today',
            'data' => $data,
        ];
    }

    public function actionDashboardAnalytics() {
        return $this->render('dashboard-analytics');
    }

    public function actionSubscriptions() {
        $plans = Plan::find()->where(['status' => 1])->all();
        $currentPlanInfo = Yii::$app->user->identity->planInformation()['data'];

        return $this->render('subscriptions', [
            'school_id' => Yii::$app->user->id,
            'plans' => $plans,
            'currentPlanInfo' => $currentPlanInfo,
        ]);
    }

    public function actionUpgrade($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $user = Yii::$app->user->identity;
        if (!empty($id)) {

            // Prevent renewal of trial plan
            if ($user->plan_id == 1 && $user->plan_id == $id) {
                return [
                    'success' => false,
                    'message' => Yii::t('app', 'You cannot renew the Trial Plan'),
                    'status' => 400,
                ];
            }

            $_newPlan = Plan::find()
                ->where(['id' => $id])
                ->andWhere(['status' => 1])
                ->one();

            if (!isset($_newPlan)) {
                return [
                    'success' => false,
                    'message' => 'Invalid plan_id',
                    'status' => 401,
                ];
            }

            $upgradeTo = $user->plan->upgrade_to ?? '';
            if (preg_match('/\b' . $id . '\b/', $upgradeTo)) {
                $_info = $user->planInformation();
                if ($_info['success']) {
                    if ($id != (string)$user->plan_id) {
                        $_info['data']['final_amount'] = sprintf('%.2f', ($_newPlan->price));
                    } else {
                        $_info['data']['remaining_balance'] = '0';
                        $_info['data']['final_amount'] = sprintf('%.2f', $_newPlan->price);
                    }

                    // Create sale
                    $item = [
                        'title' => Yii::t('app', 'Plan subscription'),
                        'amount' => $_newPlan->price,
                    ];

                    $metadata = [
                        'current_plan_id' => $user->plan_id,
                        'new_plan_id' => $_newPlan->id,
                    ];

                    $sale = Sale::newSale('mybaby', null, 'school', $user->id, [$item], 'plan-upgrade', $metadata);
                    if ($sale['success']) {
                        Yii::$app->session->setFlash('success', Yii::t('app', 'Invoice generated. Please pay to upgrade your plan'));
                        return [
                            'success' => true,
                            'redirectUrl' => Url::to(['/payment/index', 'school_id' => $user->id]),
                        ];
                    } else {
                        return $sale;
                    }
                }
                return $_info;
            }
        }

        return [
            'success' => false,
            'message' => 'Cannot upgrade/downgrade to selected plan',
            'status' => 402,
        ];
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = "login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
