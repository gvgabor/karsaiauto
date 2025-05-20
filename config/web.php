<?php

use app\models\base\Felhasznalok;
use app\modules\admin\Admin;
use yii\symfonymailer\Mailer;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id'             => 'basic',
    'basePath'       => dirname(__DIR__),
    'bootstrap'      => ['log'],
    'defaultRoute'   => 'index',
    'aliases'        => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'       => 'hu-HU',
    'sourceLanguage' => 'en-US',
    'name'           => mb_strtoupper('karsai autó'),
    'components'     => [
        'request'      => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ETQkYIG7hliyy-ddOORg4n6WbRU7RkhR',
            'parsers'             => [
                'application/json'    => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ],
        ],
        'cache'        => [
            'class' => 'yii\caching\FileCache',
        ],
        'user'         => [
            'identityClass'   => Felhasznalok::class,
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer'       => [
            'class'            => Mailer::class,
            'viewPath'         => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'           => $db,
        'urlManager'   => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules'               => [
                'admin'                                  => 'admin/index',
                'admin/<action:\w+>'                     => 'admin/index/<action>',
                'admin/RemoveFelhasznalo/<id:\d+>'       => 'admin/index/remove-felhasznalo',
                'admin/RemoveFelhasznaloiJogok/<id:\d+>' => 'admin/index/remove-felhasznaloi-jogok',
                'admin/RemoveMenu/<id:\d+>'              => 'admin/index/remove-menu',
            ],
        ],
        'i18n'         => [
            'translations' => [
                'app*' => [
                    'class'          => yii\i18n\PhpMessageSource::class,
                    'basePath'       => '@app/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap'        => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager', // vagy PhpManager
        ],
    ],
    'modules'        => [
        'admin' => [
            'class'        => Admin::class,
            'defaultRoute' => 'index',
            'layoutPath'   => '@app/views/layouts',
            'layout'       => 'admin-main',
        ]
    ],
    'params'         => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
//    $config['bootstrap'][] = 'debug';
//    $config['modules']['debug'] = [
//        'class' => 'yii\debug\Module',
//        // uncomment the following to add your IP if you are not connecting from localhost.
//        //'allowedIPs' => ['127.0.0.1', '::1'],
//    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
