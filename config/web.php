<?php

use app\modules\Module;

use yii\filters\Cors;
$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'KzeF5007GLVxtoLvEjbok1tnFsISYelA',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'keyPrefix' => 'myapp'
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'cookieParams' => [
                'path' => '/',
                'httpOnly' => true,
            ],
            'timeout' => 3600,
            'savePath' => '@runtime/session',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@runtime/logs/queue.log',
                ],
            ],
        ],
        'db' => $db,
        'user' => [
            'identityClass' => 'app\modules\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['site/login'],
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'port' => '587',
                'username' => 'huysanti123456@gmail.com',
                'password' => 'buxk ghay epzs gclb',
                'encryption' => 'tls',
            ],
        ],
//        'queue' => [
//            'class' => \yii\queue\file\Queue::class,
//            'path' => '@runtime/queue',
//          ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db',
            'tableName' => '{{%queue}}',
            'channel' => 'default',
            'mutex' => \yii\mutex\MysqlMutex::class,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
            ],
        ],

       'authManager' => [
        'class' => 'yii\rbac\DbManager',
        ],

        'locationComponent' => [
            'class' => 'app\modules\components\LocationComponent',
        ],

        'sms' => [
            'class' => 'abhimanyu\sms\components\Sms',
            'transportType' => 'nexmo',
            'transportOptions' => [
                'api_key' => '9901673f21204e10799e366272a73f26-322da15b-bf89-41e4-b011-db600a4a3e45',
//                'api_secret' => 'your_nexmo_api_secret',
//                'from' => 'your_nexmo_phone_number',
            ],
        ],
    ],

//    'modules' => [
//        'api' => [
//            'class' => 'yii\base\Module',
//            'modules' => [
//                'v1' => [
//                    'class' => 'app\modules\Module',
//                ],
//            ],
//        ],
//    ],
    'modules' => [
        'api' => [
            'class' => 'yii\base\Module',
            'modules' => [
                'v1' => [
                    'class' => 'app\modules\Module',
                ],
            ],
            'as corsFilter' => [
                'class' => Cors::class,
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                ],
            ],
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
