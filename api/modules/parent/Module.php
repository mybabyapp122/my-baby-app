<?php

namespace api\modules\parent;

use Yii;

/**
 * Module module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'api\modules\parent\controllers';

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
            'identityCookie' => ['name' => 'parent', 'httpOnly' => true],
            'idParam' => 'client_id', //this is important !
        ]);
    }
}
