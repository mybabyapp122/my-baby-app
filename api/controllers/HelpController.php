<?php
namespace api\controllers;

use api\modules\client\models\Login;
use common\libraries\CustomWidgets;
use common\models\Image;
use common\models\User;
use Yii;
use yii\base\Security;
use yii\rest\Controller;
use yii\base\DynamicModel;
use yii\web\Response;

class HelpController extends Controller {
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
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Set the response format to HTML by default
        \Yii::$app->response->format = Response::FORMAT_HTML;

        $lang = Yii::$app->request->post('lang', null);
        if (empty($lang)) {
            $lang = Yii::$app->request->get('lang', 'en');
        }
        Yii::$app->language = $lang;
        return true;
    }

    public function actionIndex() {
        return $this->render('faq', [
            'heading' => Yii::$app->request->post('heading', Yii::t('app', 'Frequently Asked Questions')),
            'title' => Yii::$app->request->post('title', ''),
            'body' => Yii::$app->request->post('body', ''),
        ]);
    }

    private function renderData($data) {
        $data['heading'] = $data['heading'] ?? Yii::t('app', 'Frequently Asked Questions');
        return $this->render('faq', $data);
    }

    public function actionNewAnnouncements() {
        $data = [
            'title' => Yii::t('app', 'I cannot add new announcements'),
            'body' => [
                Yii::t('app', "To add a new announcement, make sure you have the necessary permissions. If you are authorized, navigate to the announcements section and look for the 'Add Announcement' button. Fill out the form and click 'Submit'."),
                Yii::t('app', "If you still encounter issues, please check your internet connection or try refreshing the page."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionCannotSeeImagesInFeed() {
        $data = [
            'title' => Yii::t('app', 'I cannot see images in feed'),
            'body' => [
                Yii::t('app', "If images are not displaying in your feed, ensure that your device is connected to the internet. Sometimes, slow connections can prevent images from loading."),
                Yii::t('app', "You can also try clearing your browser's cache or refreshing the feed. If the issue persists, please contact support."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionCannotPostOnFeed() {
        $data = [
            'title' => Yii::t('app', 'I cannot post on feed'),
            'body' => Yii::t('app', "To post on the feed, make sure you are logged in and have the appropriate permissions. If you are still unable to post, try logging out and logging back in. If the problem continues, please reach out for assistance."),
        ];
        return $this->renderData($data);
    }

    public function actionEditAttendance() {
        $data = [
            'title' => Yii::t('app', 'How do I edit an attendance?'),
            'body' => [
                Yii::t('app', "To edit attendance, navigate to the attendance section of the app. Locate the specific entry you wish to change and click on 'Edit'."),
                Yii::t('app', "Make your changes and then save. If you have any issues, ensure you have the necessary permissions to edit attendance records."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionChangePassword() {
        $data = [
            'title' => Yii::t('app', 'Can I change my password?'),
            'body' => Yii::t('app', "Yes, you can change your password by going to the settings section of your account. Look for 'Change Password', enter your current password along with the new password, and save the changes."),
        ];
        return $this->renderData($data);
    }

    public function actionChangeEmail() {
        $data = [
            'title' => Yii::t('app', 'Can I change my email?'),
            'body' => [
                Yii::t('app', "To change your email address, go to your account settings. There, you will find the option to update your email."),
                Yii::t('app', "After updating, make sure to confirm the new email by checking your inbox for a confirmation link."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionResetPassword() {
        $data = [
            'title' => Yii::t('app', 'How do I reset my password?'),
            'body' => [
                Yii::t('app', "If you forgot your password, click on 'Forgot Password?' on the login page. Enter your registered email address and follow the instructions sent to your inbox."),
                Yii::t('app', "Once you receive the email, click the link to reset your password."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionProgressReports() {
        $data = [
            'title' => Yii::t('app', 'Why can’t I see my child’s progress reports?'),
            'body' => Yii::t('app', "If you can't see progress reports, ensure that your child is enrolled in the current class and that reports have been published by the teachers."),
        ];
        return $this->renderData($data);
    }

    public function actionUpdateProfile() {
        $data = [
            'title' => Yii::t('app', 'How do I update my profile information?'),
            'body' => [
                Yii::t('app', "You can update your profile information by navigating to the account settings section. From there, click on 'Edit Profile'."),
                Yii::t('app', "Make your changes and be sure to save them before exiting the page."),
            ],
        ];
        return $this->renderData($data);
    }


    public function actionPastAnnouncements() {
        $data = [
            'title' => Yii::t('app', 'Can I view past announcements?'),
            'body' => Yii::t('app', "Yes, you can view past announcements by navigating to the announcements section. Look for a tab or link labeled 'Past Announcements' to access them."),
        ];
        return $this->renderData($data);
    }

    public function actionReportIssue() {
        $data = [
            'title' => Yii::t('app', 'How do I report an issue or concern?'),
            'body' => Yii::t('app', "To report an issue, go to the support or help section of the app. Fill out the contact form with details about your concern, and submit it. Our team will get back to you shortly."),
        ];
        return $this->renderData($data);
    }

    public function actionForgotPassword() {
        $data = [
            'title' => Yii::t('app', 'What should I do if I forgot my password?'),
            'body' => [
                Yii::t('app', "If you forgot your password, click on 'Forgot Password?' on the login page. Enter your registered email address and follow the instructions sent to your inbox."),
                Yii::t('app', "Once you receive the email, click the link to reset your password."),
            ],
        ];
        return $this->renderData($data);
    }

    public function actionNotifications() {
        $data = [
            'title' => Yii::t('app', 'Can I receive notifications for new announcements?'),
            'body' => Yii::t('app', "Yes, you can enable notifications for new announcements in your account settings under 'Notification Preferences'."),
        ];
        return $this->renderData($data);
    }

    public function actionContactTeacher() {
        $data = [
            'title' => Yii::t('app', 'How do I contact a teacher or administrator?'),
            'body' => Yii::t('app', "To contact a teacher or administrator, go to the 'Contact Us' section of the app. You will find options to reach out directly via email or a contact form."),
        ];
        return $this->renderData($data);
    }

    public function actionDeletePost() {
        $data = [
            'title' => Yii::t('app', 'Is there a way to delete a post from the feed?'),
            'body' => Yii::t('app', "Yes, if you are the author of the post, you can delete it by clicking on the 'Delete' option associated with your post."),
        ];
        return $this->renderData($data);
    }

    public function actionSignOut() {
        $data = [
            'title' => Yii::t('app', 'How do I sign out of the application?'),
            'body' => Yii::t('app', "To sign out, click on your profile icon in the top corner of the app and select 'Sign Out' from the dropdown menu."),
        ];
        return $this->renderData($data);
    }

    public function actionChangeNotifications() {
        $data = [
            'title' => Yii::t('app', 'Can I change my notification preferences?'),
            'body' => Yii::t('app', "Yes, you can change your notification preferences in the settings section under 'Notifications'. Adjust them according to your needs."),
        ];
        return $this->renderData($data);
    }

    public function actionChildSick() {
        $data = [
            'title' => Yii::t('app', 'What should I do if my child is sick and cannot attend?'),
            'body' => Yii::t('app', "If your child is sick, please notify the school through the app or contact the teacher directly. This helps us keep track of attendance accurately."),
        ];
        return $this->renderData($data);
    }

    public function actionSchoolCalendar() {
        $data = [
            'title' => Yii::t('app', 'How do I find the school calendar?'),
            'body' => Yii::t('app', "You can find the school calendar in the app under the 'Calendar' section, where important dates and events are listed."),
        ];
        return $this->renderData($data);
    }

    public function actionEnrollActivities() {
        $data = [
            'title' => Yii::t('app', 'Can I enroll my child in extracurricular activities through the app?'),
            'body' => Yii::t('app', "Yes, you can enroll your child in extracurricular activities through the app. Navigate to the 'Activities' section and select the ones you are interested in."),
        ];
        return $this->renderData($data);
    }

    public function actionPayFees() {
        $data = [
            'title' => Yii::t('app', 'How do I view and pay fees or tuition online?'),
            'body' => Yii::t('app', "To view and pay fees or tuition online, go to the 'Fees' section in the app. There, you can see the outstanding fees and proceed to make payments securely."),
        ];
        return $this->renderData($data);
    }

    public function actionTechnicalIssue() {
        $data = [
            'title' => Yii::t('app', 'What do I do if I encounter a technical issue?'),
            'body' => [
                Yii::t('app', "If you encounter a technical issue, first try restarting the app or your device. If the problem persists, contact our support team through the help section."),
                Yii::t('app', "Provide detailed information about the issue to help us assist you better."),
            ],
        ];
        return $this->renderData($data);
    }


}
