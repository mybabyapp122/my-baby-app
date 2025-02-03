<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'sourceLanguage' =>'en-US',
    'language'       => 'en-US',
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
    ],
    'controllerNamespace' => 'api\controllers',
    'modules' => [
        'parent' => [
            'basePath' => '@app/modules/parent',
            'class' => 'api\modules\parent\Module'
        ],
        'teacher' => [
            'basePath' => '@app/modules/teacher',
            'class' => 'api\modules\teacher\Module'
        ],
    ],
    'components' => [
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'mailer' => [
            'htmlLayout' => '@common/mail/layouts/html',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'class'=>'yii\web\User',
            'enableAutoLogin' => false,
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],

    ],
    'params' => $params,
];
