<?php
namespace api\controllers;

use common\libraries\CustomWidgets;
use common\libraries\SmartNSP;
use common\models\Address;
use common\models\Categories;
use common\models\Device;
use common\models\DevicePreferences;
use common\models\Image;
use common\models\Plan;
use common\models\Preferences;
use common\models\Provider;
use common\models\ProviderStaff;
use common\models\Status;
use common\models\Translation;
use Yii;
use yii\rest\Controller;

class FetchController extends Controller
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

    public function actionPreferences() {
        $model = Preferences::find()->where(['status' => 1])->all();

        return [
            'success' => true,
            'message' => 'Preferences fetched',
            'status' => 200,
            'data' => $model,
        ];
    }

    public function actionStatuses() {
        return CustomWidgets::returnSuccess(Status::find()->all());
    }

    public function actionRegisterDeviceAndUpdatePreferences()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $device =  Yii::$app->request->post('device', null);
        $preferences =  Yii::$app->request->post('preferences', null);
        $device = json_decode($device, true);
        $preferences = json_decode($preferences, true);
        $preferences['last_used'] = date('Y-m-d H:i:s');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Check if the device is already registered
            $device_model = Device::findOne(['device_id' => $device['device_id']]);
            if (!$device_model) {
                $device_model = new Device();
                $device_model->attributes = $device;
                if (!$device_model->save()) {
                    return [
                        'success' => false,
                        'message' => 'Failed to save device information.',
                        'status' => 400,
                    ];
                }
            }

            // If user logged in on multiple devices, store the latest device info and remove the old ones
            if (array_key_exists('user_id', $preferences) && !empty($preferences['user_id'])) {
                $existing = DevicePreferences::find()
                    ->where(['project' => 'mybaby'])
                    ->andWhere(['title' => 'user_id'])
                    ->andWhere(['value' => $preferences['user_id']])
                    ->all();
                if (!empty($existing)) {
                    foreach ($existing as $_existing) {
                        $existing_preferences = DevicePreferences::find()
                            ->where(['device_id' => $_existing->device_id])
                            ->andWhere(['project' => $_existing->project])
                            ->all();
                        if (!empty($existing_preferences)) {
                            foreach ($existing_preferences as $ep) {
                                $ep->delete();
                            }
                        }
                    }
                }
            }

            // Now handle preferences
            foreach ($preferences as $title => $value) {
                $dp = DevicePreferences::findOne([
                    'device_id' => $device_model->id,
                    'project' => 'mybaby',
                    'title' => $title,
                ]);

                if (!$dp) {
                    $dp = new DevicePreferences();
                    $dp->device_id = $device_model->id;
                    $dp->project = 'mybaby';
                    $dp->title = $title;
                }

                $dp->value = $value;
                if (!$dp->save()) {
                    return [
                        'success' => false,
                        'message' => "Failed to save device preference: $title",
                        'status' => 400,
                    ];
                }
            }

            $transaction->commit();
            return [
                'success' => true,
                'message' => 'Device and preferences updated successfully.',
                'status' => 200,
                'data' => $device_model,
            ];
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'status' => 400
            ];
        }
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

}
