<?php
namespace backend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Logged-in users only
                        'matchCallback' => function ($rule, $action) {
                            return $this->checkAccess($action->id);
                        }
                    ],
                ],
            ],
        ];
    }

    protected function checkAccess($actionId)
    {
        $user = Yii::$app->user->identity;
        if (!$user) {
            return false;
        }

        // Global plan and auth key checks
        if (!$user->validatePlan()) {
            return false;
        }


        //TODO :: allow logged in school to access his pages only
        return true;

        // Role-based access control
//        if ($actionId === 'schools') {
            // Admins have full access to the schools action
            if ($user->role === 'admin') {
                return true;
            }

            // Schools can only view their own data
            if ($user->role === 'school') {
                $requestedId = Yii::$app->request->get('school_id');
                if (empty($requestedId)) $requestedId = Yii::$app->request->get('id');

                return $requestedId == $user->id; // Only access own ID
            }

            // Deny other roles
            return false;
//        }

//        return true; // Allow other actions as needed
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Check if the user is logged in and has a valid plan
        $user = Yii::$app->user->identity;
        if ($user) {
            if (!$user->validatePlan()) return $this->redirect('/site/subscriptions');
//            throw new ForbiddenHttpException(Yii::t('app', 'You must have a valid plan to access this page.'));
        }
        return true;
    }

}
