<?php

namespace common\components;

use common\models\User;
use Yii;
use yii\base\Widget;
//use yii\bootstrap\ButtonDropdown;
use yii\helpers\Url;

class languageSwitcher extends Widget
{

    public $languages = [
        'en' => 'English',
        'ar' => 'عربي',
    ];

    public function init()
    {
        if(php_sapi_name() === 'cli')
        {
            return true;
        }

        parent::init();

        $cookies = Yii::$app->request->cookies;
        $languageNew = Yii::$app->request->get('lang');
        if($languageNew)
        {
            if(isset($this->languages[$languageNew]))
            {
                Yii::$app->language = $languageNew;

                $this->setLanguage($languageNew);
            }
        }
        elseif($cookies->has('lang'))
        {
            Yii::$app->language = $cookies->getValue('lang');
        }elseif(!Yii::$app->user->isGuest)
        {

            if(!empty(Yii::$app->user->identity->language)) {
                Yii::$app->language = Yii::$app->user->identity->language;
                $this->setLanguage(Yii::$app->user->identity->language);
          }
        }
    }

    public function setLanguage($language){

        $_cookies = Yii::$app->response->cookies;
        $_cookies->add(new \yii\web\Cookie([
            'name' => 'lang',
            'value' => $language
        ]));
        if (!\Yii::$app->user->isGuest) {
            $user = \common\models\User::find()->where(['id' => Yii::$app->user->id])->one();
            $user->language = $language;
            $user->save(false);
        }
    }

    public function run(){
        $languages = $this->languages;
//        $current = $languages[Yii::$app->language];
        unset($languages[Yii::$app->language]);

        $items = [];
        foreach($languages as $code => $language)
        {
            $temp = [];
            $temp['label'] = $language;
            $temp['url'] = Url::current(['lang' => $code]);
            array_push($items, $temp);
        }

    }

}