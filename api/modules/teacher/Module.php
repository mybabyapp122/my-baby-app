<?php

namespace api\modules\teacher;

use Yii;

/**
 * Module module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\teacher\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
//            'loginUrl' => ['yonetim/default/login'],
            'identityCookie' => ['name' => 'teacher', 'httpOnly' => true],
            'idParam' => 'id', //this is important !
        ]);
    }
}
