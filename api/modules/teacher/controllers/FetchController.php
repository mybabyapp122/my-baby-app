<?php
namespace api\modules\teacher\controllers;

use common\libraries\CustomWidgets;
use common\libraries\SmartNSP;
use common\models\Address;
use common\models\Categories;
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


    public function actionCategories() {
        $cats = Categories::find()
            ->where(['status' => 1])
            ->all();

        $result = [];
        foreach ($cats as $cat) {
            $result[$cat->id] = Yii::$app->language == 'en' ? $cat->name : $cat->name_ar;
        }

        return CustomWidgets::returnSuccess($result);
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

    public function actionTranslations() {
        $model = Translation::find()->all();

        return [
            'success' => true,
            'message' => 'Translations fetched',
            'status' => 200,
            'data' => $model,
        ];
    }

    public function actionRegisterDeviceAndUpdatePreferences()
    {
        if (empty(Yii::$app->request->bodyParams)) {
            $params = Yii::$app->request->queryParams;
        } else {
            $params = Yii::$app->request->bodyParams;
        }
        $fetchController = new \api\controllers\FetchController('fetch', Yii::$app);
        return $fetchController->runAction('register-device-and-update-preferences', $params);
    }

    /**
     * @return array
     * input: place, position
     */
    public function actionMapValidation() {
        $place = '{"name":"3817 Saad Bin Othman - حي مذينب","street":"3817 Saad Bin Othman - حي مذينب","isoCountryCode":"SA","country":"Saudi Arabia","postalCode":"DMPB3817","administrativeArea":"Medina Region","subAdministrativeArea":"Medina","locality":"المدينة المنورة","subLocality":"حي مذينب","thoroughfare":"Saad Bin Othman","subThoroughfare":"3817"}';
        $position = '[24.447418790317016,39.68333501368761]';

        if (Yii::$app->request->post()) {
            $place = $_POST['place'];
            $position = $_POST['position'];
        }

        return Address::readMapAddress($place, $position);
    }

    public function actionRulesList() {
        if (empty(Yii::$app->request->bodyParams)) {
            $params = Yii::$app->request->queryParams;
        } else {
            $params = Yii::$app->request->bodyParams;
        }

        $fetchController = new \api\controllers\FetchController('fetch', Yii::$app);
        return $fetchController->runAction('rules-list', $params);
    }

    public function actionConnectInstagram()
    {
        $data = "

  <h3>Steps to Add a \"Book\" Button on Instagram</h3>
  <h4>Attract your instagram followers by adding a \"Book\" button to your account.</h4>
  
  <ul>
    <li><strong>Convert to a Business or Creator Account:</strong>
      <ul>
        <li>If you haven't already, you need to convert your Instagram account to a business or creator account. This is necessary to access business features, including the ability to add action buttons like \"Book Appointment\".</li>
        <li>Go to your Instagram profile, tap on the three horizontal lines in the top right corner.</li>
        <li>Tap on \"Settings\" -> \"Account\" -> \"Switch to Professional Account\".</li>
        <li>Follow the prompts to choose either \"Business\" or \"Creator\" account type based on your needs.</li>
      </ul>
    </li>
    
    <li><strong>Connect to a Compatible Service:</strong>
      <ul>
        <li>After converting to a business or creator account, go to your profile and tap on \"Edit Profile\".</li>
        <li>Under \"Public Business Information\", tap on \"Contact Options\" -> \"Add Action Button\".</li>
        <li>Select \"Book\" and choose a service provider from the list of Instagram's partner booking platforms (e.g., Appointments on Facebook, Booksy, Acuity Scheduling).</li>
        <li>If your preferred service is not listed, you might need to connect through an external link (if supported by Instagram).</li>
      </ul>
    </li>
    
    <li><strong>Set Up the Action Button:</strong>
      <ul>
        <li>Once you select a service, Instagram will redirect you to log into your account with the service provider.</li>
        <li>Follow the provider's instructions to link your account and integrate your booking system with Instagram.</li>
        <li>Customize the button label (e.g., \"Book Appointment\") and complete any additional setup required by the service provider.</li>
      </ul>
    </li>
    
    <li><strong>Verify and Test:</strong>
      <ul>
        <li>After setup, go back to your Instagram profile and verify that the \"Book Appointment\" button appears under your bio.</li>
        <li>Test the button to ensure it directs users to your booking page correctly.</li>
      </ul>
    </li>
  </ul>
  
  <p><strong>Additional Tips:</strong></p>
  <ul>
    <li><strong>Business Information:</strong> Make sure your business information (address, contact details, services offered) is accurate and up-to-date as this information may be displayed alongside the booking button.</li>
    <li><strong>Supported Services:</strong> Instagram periodically updates its list of supported booking partners, so if your preferred service isn’t available immediately, check back later or consider alternatives.</li>
  </ul>

        ";

        return [
            'success' => true,
            'message' => 'Fetched',
            'data' => $data,
        ];
    }

    public function actionPlans()
    {
        // Fetch all plans from the database
        $plans = Plan::find()->where(['status'  => 1])->all();

        $data = [];
        foreach ($plans as $plan) {
            $title = Yii::$app->language == 'en' ? $plan->name : $plan->name_ar;
            $description = Yii::$app->language == 'en' ? $plan->description : $plan->description_ar;

            $subscriptionPeriod = $plan->subscription_period;
            $periodString = $this->convertDaysToPeriodString($subscriptionPeriod);

            $subtitle = $plan->price . ' ' . Yii::t('app', 'SAR') .' / ' . $periodString;
            $display = $description . ' ' . Yii::t('app', 'for') . ' ' . $plan->price . ' ' .  Yii::t('app', 'SAR') . ' ' . Yii::t('app', 'per') . ' ' . $periodString;

            $data[$plan->id] = [
                'title' => $title,
                'subtitle' => $subtitle,
                'display' => $display,
            ];
        }

        return [
            'success' => true,
            'message' => 'Fetched',
            'data' => $data,
        ];
    }

    private function convertDaysToPeriodString($days)
    {
        if ($days < 30) {
            return $days . Yii::t('app', ' days');
        } elseif ($days < 365) {
            $months = floor($days / 30);
            return $months . ' ' .   ($months == 1 ? Yii::t('app', 'month') : Yii::t('app', 'months'));
        } else {
            $years = floor($days / 365);
            return $years . ' ' . ($years == 1 ? Yii::t('app', 'year') : Yii::t('app', 'years'));
        }
    }

    public function actionValidateReferralCode() {
        $code = Yii::$app->request->post('code', null);
        $provider = Provider::find()
            ->where(['referral_code' => $code])
            ->one();

        if (!isset($provider)) {
            return CustomWidgets::returnFail('Referral code is invalid', ['d' => $provider]);
        }
        return CustomWidgets::returnSuccess([], 'Referral code is valid!');
    }

    function actionHelpCenter() {
        $questions = [
            [
                'title' => Yii::t('app', 'I cannot add new announcements'),
                'url' => CustomWidgets::apiUrl() . '/help/new-announcements',
            ],
            [
                'title' => Yii::t('app', 'I cannot see images in feed'),
                'url' => CustomWidgets::apiUrl() . '/help/cannot-see-images-in-feed',
            ],
            [
                'title' => Yii::t('app', 'I cannot post on feed'),
                'url' => CustomWidgets::apiUrl() . '/help/cannot-post-on-feed',
            ],
            [
                'title' => Yii::t('app', 'How do I edit an attendance?'),
                'url' => CustomWidgets::apiUrl() . '/help/edit-attendance',
            ],
            [
                'title' => Yii::t('app', 'Can I change my password?'),
                'url' => CustomWidgets::apiUrl() . '/help/change-password',
            ],
            [
                'title' => Yii::t('app', 'Can I change my email?'),
                'url' => CustomWidgets::apiUrl() . '/help/change-email',
            ],
            [
                'title' => Yii::t('app', 'How do I reset my password?'),
                'url' => CustomWidgets::apiUrl() . '/help/reset-password',
            ],
            [
                'title' => Yii::t('app', 'Why can’t I see my child’s progress reports?'),
                'url' => CustomWidgets::apiUrl() . '/help/progress-reports',
            ],
            [
                'title' => Yii::t('app', 'How do I update my profile information?'),
                'url' => CustomWidgets::apiUrl() . '/help/update-profile',
            ],
            [
                'title' => Yii::t('app', 'Can I view past announcements?'),
                'url' => CustomWidgets::apiUrl() . '/help/past-announcements',
            ],
            [
                'title' => Yii::t('app', 'How do I report an issue or concern?'),
                'url' => CustomWidgets::apiUrl() . '/help/report-issue',
            ],
            [
                'title' => Yii::t('app', 'What should I do if I forgot my password?'),
                'url' => CustomWidgets::apiUrl() . '/help/forgot-password',
            ],
            [
                'title' => Yii::t('app', 'Can I receive notifications for new announcements?'),
                'url' => CustomWidgets::apiUrl() . '/help/notifications',
            ],
            [
                'title' => Yii::t('app', 'How do I contact a teacher or administrator?'),
                'url' => CustomWidgets::apiUrl() . '/help/contact-teacher',
            ],
            [
                'title' => Yii::t('app', 'Is there a way to delete a post from the feed?'),
                'url' => CustomWidgets::apiUrl() . '/help/delete-post',
            ],
            [
                'title' => Yii::t('app', 'How do I sign out of the application?'),
                'url' => CustomWidgets::apiUrl() . '/help/sign-out',
            ],
            [
                'title' => Yii::t('app', 'Can I change my notification preferences?'),
                'url' => CustomWidgets::apiUrl() . '/help/change-notifications',
            ],
            [
                'title' => Yii::t('app', 'What should I do if my child is sick and cannot attend?'),
                'url' => CustomWidgets::apiUrl() . '/help/child-sick',
            ],
            [
                'title' => Yii::t('app', 'How do I find the school calendar?'),
                'url' => CustomWidgets::apiUrl() . '/help/school-calendar',
            ],
            [
                'title' => Yii::t('app', 'Can I enroll my child in extracurricular activities through the app?'),
                'url' => CustomWidgets::apiUrl() . '/help/enroll-activities',
            ],
            [
                'title' => Yii::t('app', 'How do I view and pay fees or tuition online?'),
                'url' => CustomWidgets::apiUrl() . '/help/pay-fees',
            ],
            [
                'title' => Yii::t('app', 'What do I do if I encounter a technical issue?'),
                'url' => CustomWidgets::apiUrl() . '/help/technical-issue',
            ],
        ];

        $data = [
            'questions' => $questions,
            'chat' => '',
        ];

        return CustomWidgets::returnSuccess($data);
    }

}
