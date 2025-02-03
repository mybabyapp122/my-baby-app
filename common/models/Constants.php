<?php

namespace common\models;

use common\libraries\CustomWidgets;
use Yii;

class Constants extends \yii\db\ActiveRecord
{
    CONST APP_NAME = 'MyBaby';

    CONST API_URL = 'https://api.mybabyapp.net';
    CONST BACKEND_URL = 'https://dash.mybaby.com';
    CONST FRONTEND_URL = '';

    CONST API_URL_LOCAL = 'https://api.mybaby.test';
    CONST BACKEND_URL_LOCAL = 'http://dash.mybaby.test';
    CONST FRONTEND_URL_LOCAL = 'https://mybaby.test';
}
