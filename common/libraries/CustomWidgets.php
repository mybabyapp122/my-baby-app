<?php
namespace common\libraries;

use api\models\Creditcard;
use api\models\Order;
use common\models\User;
use common\models\Constants;
use yii\base\DynamicModel;
use Yii;
use yii\httpclient\Client;
use yii\web\BadRequestHttpException;
use linslin\yii2\curl;

class CustomWidgets {

    public static function apiUrl() {
//        return Constants::API_URL;
        return Constants::API_URL_LOCAL;
    }

    public static function frontendUrl() {
//        return Constants::FRONTEND_URL;
        return Constants::FRONTEND_URL_LOCAL;
    }

    public static function backendUrl() {
//        return Constants::FRONTEND_URL;
        return Constants::BACKEND_URL_LOCAL;
    }

    public static $hiddenChars = ['‎', '‏'];



    //Date Difference Calculation Actions:
    //https://stackoverflow.com/questions/2870295/increment-date-by-one-month
    //Action 1 of 2
    public static function add_period($months, $days, \DateTime $dateObject)
    {
        // Clone the original date to avoid modifying it directly
        $newDate = clone $dateObject;

        // Add months if months is greater than zero
        if ($months > 0) {
            $newDate->modify('last day of +' . $months . ' month');

            if ($dateObject->format('d') > $newDate->format('d')) {
                $dateObject->modify('last day of +' . $months . ' month');
            } else {
                $dateObject->modify('+' . $months . ' months');
            }
        }

        // Add days if days is greater than zero
        if ($days > 0) {
            $dateObject->modify('+' . $days . ' days');
        }

        return $dateObject;
    }

    //Action 2 of 2
    //We call this action, this action calls previous one.
    //Input: DateTime/String (format: Y-m-d)
    //Output: DateTime (object)
    public static function endCycle($d1, $months, $days)
    {
        $date = new \DateTime($d1);

        // Call the add_period function to add the months and days
        $newDate = CustomWidgets::add_period($months, $days, $date);

        // Goes back 1 day from date, remove if you want the same day of the month
        // $newDate->sub(new \DateInterval('P1D'));

        return $newDate;
    }

    public static function daysAgo($days, \DateTime $currentDate) {
        $previous_date = ($currentDate)->sub(new \DateInterval('P' . $days . 'D'));
        return $previous_date;
    }

    public static function daysAhead($days, \DateTime $currentDate) {
        $previous_date = ($currentDate)->add(new \DateInterval('P' . $days . 'D'));
        return $previous_date;
    }

    public static function getTranslationMessages() {
        $translationsArr = Yii::getAlias('@common/messages/' . Yii::$app->language . '/app.php');
        $translations = [];
        if (file_exists($translationsArr)) {
            $translations = include $translationsArr;
        }
        return json_encode($translations);
    }

    /**
     * @param $string
     * @param int $limit
     * @return false|string|string[]|null
     * REMOVES ALL SPECIAL CHARACTERS INCLUDING OTHER LANGUAGE CHARACTERS
     */
    public static function clean($string, $limit = 42) {
        $string =  preg_replace('/[^A-Za-z0-9\-\s]/', '', $string); // Removes special chars.
        if (strlen($string) > 42) {
            $string = substr($string, 0, $limit);
        }
        return $string;
    }

//    public static function translateString($text, $skip = false) {
//        if ($skip || $text == null) return $text;
//        $is_arabic = preg_match('/\p{Arabic}/u', $text);
//        if( $is_arabic ):
//            $result = \Yii::$app->translate->ArabicToEnglish( $text );
//            if( isset($result['status']) && $result['status'] == 'success'):
//                $textModified = $result['data']['text_en'];
//                $textModified = self::clean($textModified);
//                return $textModified;
//            endif;
//        endif;
//        return $text;
//    }

    /**
     * @param string $ios
     * @param string $android
     * @return bool
     * Used for version specific conditions
     */
    public static function isLatestVersion($ios = '1.2', $android = '2.1') {
        if (isset($_POST['platform']) && isset($_POST['app_version'])) {
            if ($_POST['platform'] == 'android' && $_POST['app_version'] == $android) {
                return true;
            }
            if ($_POST['platform'] == 'ios' && $_POST['app_version'] == $ios) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $str
     * @return string
     */
    public static function translate($str) {
        return Yii::t('app', $str);
    }

    //Called from transaction-invoice
    public static function buildPrice($amount) {
        return sprintf('%.2f',$amount) . ' ' . Yii::t('app', 'SAR');
    }

    public static function beautifulMobileNumber($mobile) {
        $mobile = str_replace('+966', '0', $mobile);
        $mobile = str_replace('+', '', $mobile);
        return sprintf('%010d', $mobile);
    }

    public static function truncate($string, $length=255, $append="...") {
        //$append="&hellip;"
        $string = trim($string);

        if(strlen($string) > $length) {
            $string = wordwrap($string, $length);
            $string = explode("\n", $string, 2);
            $string = $string[0] . $append;
        }

        return $string;
    }


    /**
     * @param $data
     * @param $message
     * @return array
     */
    public static function returnSuccess($data, $message = '', $encrypt = true) {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'status' => 200,
        ];
    }

    /**
     * @param $data
     * @param $message
     * @return array
     */
    public static function returnFail($message, $data = [], $status = 400) {
        return [
            'success' => false,
            'message' => $message,
            'data' => $data,
            'status' => $status,
        ];
    }

    public static function socialUrl($url, $platform = 'facebook', $removeBase = false) {
        $base = '';
        switch ($platform) {
            case 'facebook':
                $base = 'https://www.facebook.com/';
                break;
            case 'instagram':
                $base = 'https://www.instagram.com/';
                break;
            case 'snapchat':
                $base = 'https://www.snapchat.com/';
                break;
        }

        if ($removeBase) {
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                $url = "https://" . $url;
            }
            if (!preg_match("~^www\.~i", $url)) {
                $url = "www." . $url;
            }

            $handle = basename($url); // Get the last part of the URL
            $handle = substr($handle, strrpos($handle, '/')); // Get the part after the last "/"
            return $handle;
        }

        return $base . $url;
    }

    static function reformatDate($input, $format = 'Y-m-d') {
        return date($format, strtotime($input));
    }

    public static function generateRandomCode($length = 12, $uppercase = false) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if ($uppercase) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $code = '';
        $max = strlen($characters) - 1;

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, $max)];
        }

        return $code;
    }
}