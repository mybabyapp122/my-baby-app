<?php
//Run this command to extract new messages:
//php yii message/extract

return [
    'sourcePath'   => dirname(__DIR__, 2), // Points to the project root directory (common for backend, frontend, etc.)
    'languages'    => ['en','ar'], // Add the languages you want to generate files for
    'translator'   => 'Yii::t',
    'sort'         => false,
    'removeUnused' => false,
    'only'         => ['*.php'],
    'except'       => [
        '/.svn',
        '/.git',
        '/.gitignore',
        '/.gitkeep',
        '/.hgignore',
        '/.hgkeep',
        '/vendor',
        '/frontend/runtime',
        '/backend/runtime',
        '/frontend/web',
        '/backend/web',
        '/common/messages' // Exclude message directory to avoid recursion
    ],
    'format'       => 'php',
    'messagePath'  => dirname(__DIR__, 2) . '/common/messages', // Set to the common directory
    'overwrite'    => true,
];
