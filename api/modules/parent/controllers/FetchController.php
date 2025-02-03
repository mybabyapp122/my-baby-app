<?php
namespace api\modules\parent\controllers;

use api\modules\client\models\Login;
use common\libraries\CustomWidgets;
use common\models\Image;
use common\models\Translation;
use common\models\User;
use Yii;
use yii\base\Security;
use yii\rest\Controller;
use yii\base\DynamicModel;

class FetchController extends Controller {
    public $modelClass = 'common\models\Client';

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

    public function actionPrivacyPolicy() {
        return [
            'success' => true,
            'data' => $this->renderFile('@common/libraries/privacy-policy.php'),
        ];
    }

    public function actionTermsAndConditions() {
        return [
            'success' => true,
            'data' => $this->renderFile('@common/libraries/terms-and-conditions.php'),
        ];
    }

    public function actionAgreement() {
        return [
            'success' => true,
            'data' => $this->renderFile('@common/libraries/terms-and-conditions.php'),
        ];
    }

    public function actionTranslations() {
        $model = Translation::find()->all();

        return [
            'success' => true,
            'message' => 'Translations fetched',
            'status' => 200,
            'data' => $model,
        ];
    }
}
