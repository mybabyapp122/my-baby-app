<?php
namespace api\controllers;

use api\modules\client\models\Login;
use common\libraries\CustomWidgets;
use common\models\Image;
use common\models\Sale;
use common\models\User;
use Yii;
use yii\base\Security;
use yii\rest\Controller;
use yii\base\DynamicModel;

class LoginController extends Controller {
    public $modelClass = 'common\models\User';

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
        return 'At your service';
    }

    public function actionLogin()
    {
        // Get POST parameters
        $username = Yii::$app->request->post('username');
        $password = Yii::$app->request->post('password');

        // Validate inputs
        if (empty($username) || empty($password)) {
            return CustomWidgets::returnFail('Username and password are required.');
        }

        // Find user by username or email
        /**
         * @var User $user
         */
        $user = User::find()->where(['or', ['username' => $username], ['email' => $username]])->one();

        // Check if user exists
        if (!$user) {
            return CustomWidgets::returnFail('Invalid username or password.');
        }

        // Verify password
        if (!Yii::$app->security->validatePassword($password, $user->password_hash)) {
            return CustomWidgets::returnFail('Invalid username or password.');
        }

        return $this->_successfulLogin($user);
    }

    private function _successfulLogin($user) {
        if (empty($user)) {
            return CustomWidgets::returnFail('User not found');
        }

        if ($user->status != 'active' && $user->status_ex != 'invited') {
            return CustomWidgets::returnFail('Account is not active');
        }

        // Handle all validations here
//        $img = Image::readImage('client', $user->id);
//        $user = $user->toArray();
//        if ($img['success']) {
//            $user['image_url'] = $img['data'][0];
//        }

        switch ($user->role) {
            case 'teacher':
            case 'parent':
                $data = $user->basicInfoJson();
                return CustomWidgets::returnSuccess($data, 'Login successful');
            default:
                return CustomWidgets::returnFail('user not allowed to login via this api');
        }
    }

    public function actionViaAuthkey($authkey = null) {
        $data = [
            'authkey' => Yii::$app->request->post('authkey', $authkey),
        ];

        $modelData = DynamicModel::validateData($data, [
            [['authkey'] , 'required'],
        ]);

        if ($modelData->validate() ) {
            $authkey = $data['authkey'];

            $model = User::findIdentityByAccessToken($authkey);
            return $this->_successfulLogin($model);

        } else {
            return [
                'success' => false,
                'message' => $modelData->getErrors(),
                'status' => 400,
            ];
        }
    }

    public function actionForgotPassword() {
        $email = Yii::$app->request->post('email');

        $user = User::findByEmail($email);
        if (!isset($user)) {
            return CustomWidgets::returnFail(Yii::t('app', 'Invalid email address'));
        }

        $user->generatePassword();
        $user->status_ex = 'reset_password';
        $new_password = $user->plainPassword;
        $user->sendPasswordResetEmail($new_password);

        return CustomWidgets::returnSuccess([], Yii::t('app', 'A reset password has been sent to this email. Please use that to login'));
    }

}
