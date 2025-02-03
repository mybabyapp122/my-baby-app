<?php
/**
 * Run this command to extract new messages:
php yii message/extract common/config/i18n.php
 */

return [
    'sourcePath' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..',
    'languages'    => ['ar'], // Languages to generate message files for
    'translator'   => 'Yii::t',
    'sort'         => false,
    'removeUnused' => false,
    'only'         => ['*.php'], // Only extract from PHP files
    'except'       => [
        '/messages', // Exclude the messages directory from extraction
        '/vendor', // Exclude vendor directory
    ],
    'format'       => 'php',
    'messagePath'  => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'messages', // Path where messages are stored
    'overwrite'    => true,
];
