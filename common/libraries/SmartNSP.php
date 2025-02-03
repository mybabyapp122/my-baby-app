<?php
/**
 * Created by PhpStorm.
 * User: yyounus
 * Date: 2024-07-17
 * Time: 17:00
 */

namespace common\libraries;

use common\models\DevicePreferences;

class SmartNSP {

    private string $apiUrl = 'https://smartnsp.lakhana.com';
    private string $authKey = 'mybaby/.r0dQaSoyyaImP9ajYgnaLk12';
    private int $projectId = 70024;
    private string $appUrl = 'https://welcome.mybabyapp.net/';

    private string $hidden = 'false';
    private string $group_message = '';
    private string $group_title = '';

    private string $onclick_redirect = '';
    private string $receiver_email = '';
    private string $receiver_token = '';
    private string $receiver_mobile = '';
    private string $from_model = '';
    private string $from_model_id = '';
    private string $to_model = '';
    private string $to_model_id = '';
    private int $send_push = 1; //Defaults to Yes
    private int $send_email = 0;
    private int $send_sms = 0;

    private array $email_data = [];
    private string $email_html = '';

    public function setHidden()
    {
        $this->hidden = "true";
    }

    public function setEmailData($details)
    {
        $this->email_data = $details;
    }

    public function setEmailHtml($html)
    {
        $this->email_html = $html;
    }

    public function setOnClickRedirect($_route, $addUrl = false)
    {
        if($addUrl) $_route .= $this->appUrl;
        $this->onclick_redirect = $_route;
    }

    public function sendPush($enable = 1)
    {
        $this->send_push = $enable;
    }

    public function sendEmail($enable = 1)
    {
        $this->send_email = $enable;
    }

    public function sendSms($enable = 1)
    {
        $this->send_sms = $enable;
    }

    public function setReceiverEmail($text)
    {
        $this->receiver_email = $text;
    }

    public function setReceiverMobile($text)
    {
        $this->receiver_mobile = $text;
    }

    public function setReceiverToken($text)
    {
        $this->receiver_token = $text;
    }

    public function setFromModel($text)
    {
        $this->from_model = $text;
    }
    public function setFromModelId($text)
    {
        $this->from_model_id = $text;
    }
    public function setToModel($text)
    {
        $this->to_model = $text;
    }
    public function setToModelId($text)
    {
        $this->to_model_id = $text;
    }

    public function setGroupTitle($_title)
    {
        $this->group_title = $_title;
    }

    public function setGroupMessage($_title, $_message) {
        if (!empty($this->group_message)) {
            $this->group_message .= '||';
        }
        $this->group_message .= $_title . '|:|' . $_message;
    }

    public function createNotification($project, $userId, $title, $message) {
        $endpoint = $this->apiUrl . '/notification/create-notification';
        $config = [];
        // Main notification structure
        $notification = [
            'project_id' => $this->projectId,
            'title' => $title,
            'message' => $message,
        ];

        //Additional Params sent in config Array
        if ($this->hidden) $config['hidden_notification'] = $this->hidden;
        if (!empty($this->onclick_redirect)) $config['route'] = $this->onclick_redirect;
        if (!empty($this->group_title)) $config['group_title'] = $this->group_title;
        if (!empty($this->group_message)) $config['group_message'] = $this->group_message;

        $notification['send_push'] = $this->send_push;
        $notification['send_email'] = $this->send_email;
        $notification['send_sms'] = $this->send_sms;
        if ($this->send_push) {
            $fcm_token = $this->getDeviceDetail($project, $userId);
            if (!empty($fcm_token)) $this->setReceiverToken($fcm_token);
//            $this->receiver_token = $fcm_token;
            $notification['receiver_token'] = $this->receiver_token ?? 'NOT FOUND';
        }

        if ($this->send_email)
        {
            $notification['receiver_email'] = $this->receiver_email;
            $notification['email_data'] = $this->email_data;
            if (!empty($this->email_html)) $notification['email_html'] = $this->email_html;
        }

        if ($this->send_sms) $notification['receiver_mobile'] = $this->receiver_mobile;

        if (!empty($this->from_model)) $notification['from_model'] = $this->from_model;
        if (!empty($this->from_model_id)) $notification['from_model_id'] = $this->from_model_id;

        if (!empty($this->to_model)) $notification['to_model'] = $this->to_model;
        if (!empty($this->to_model_id)) $notification['to_model_id'] = $this->to_model_id;

        if (!empty($this->onclick_redirect)) $notification['onclick_redirect'] = $this->onclick_redirect;

        // Build the final body payload
        $body = [
            'notification' => $notification,
            'config' => $config,
        ];

        return $this->httpRequest($endpoint, $body);
    }

    public function getDeviceDetail($project, $userId, $key = 'fcm_token') {

        $device = DevicePreferences::find()
            ->where(['project' => $project])
            ->andWhere(['title' => 'user_id'])
            ->andWhere(['value' => $userId])
            ->one();

        if ($device && $device->device_id) {
            $detail = DevicePreferences::find()
                ->where(['device_id' => $device->device_id])
                ->andWhere(['project' => $device->project])
                ->andWhere(['title' => $key])
                ->one();

            return $detail->value ?? null;
        }
        return null;
    }

    private function httpRequest($url, $body = [], $isPost = true) {
        $json = json_encode($body);

        $headers = [
            'Content-Type: application/json',
            "Authorization: Bearer " . $this->authKey,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $isPost);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

}
