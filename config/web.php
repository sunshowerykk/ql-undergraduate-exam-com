<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'home',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'yjfsb',
        ],
        'cache' => [
            'directoryLevel'=>'2',
            'keyPrefix' => 'sw',       // 唯一键前缀
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'home/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                'home'=>[   //自定义Log
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['home'],
                    'logFile' => '@app/runtime/logs/requests.log',
                    'maxFileSize' => 1024*2,
                    'maxLogFiles' => 20,

                ],
            ],

        ],
        //'db' => require(__DIR__ . '/db.php'),
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=47.104.216.133;dbname=ql_exam',
            'username' => 'exam',
            'password' => 'exam@#$123',
            'charset' => 'utf8',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
