<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'timeZone' => 'Asia/Riyadh',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'languageSwitcher' => [
            'class' => 'common\components\languageSwitcher',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages', // Ensure this points to the common directory
                    'fileMap' => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class'=>'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
    ],
];
