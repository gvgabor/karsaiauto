<?php

use app\models\base\Felhasznalok;
use app\modules\admin\Admin;
use app\modules\autok\Autok;
use app\modules\home\Home;
use app\modules\karbantartas\Karbantartas;
use yii\i18n\PhpMessageSource;
use yii\symfonymailer\Mailer;

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$params = require __DIR__ . '/params.php';
$db     = require __DIR__ . '/db.php';

$config = [
    'id'             => 'basic',
    'basePath'       => dirname(__DIR__),
    'bootstrap'      => ['log'],
    'defaultRoute'   => 'index',
    'sourceLanguage' => 'hu-HU',
    'language'       => 'hu-HU',
    'aliases'        => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'name'       => mb_strtoupper($_ENV['APP_NAME']),
    'components' => [
        'r2' => [
            'class'     => 'app\components\R2Uploader',
            'accessKey' => $_ENV['CLOUDFLARE_ACCESS'],
            'secretKey' => $_ENV['CLOUDFLARE_SECRET'],
            'bucket'    => $_ENV['CLOUDFLARE_BUCKET'],
            'endpoint'  => 'https://' . $_ENV['CLOUDFLARE_ACCOUNT'] . '.r2.cloudflarestorage.com',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ETQkYIG7hliyy-ddOORg4n6WbRU7RkhR',
            'parsers'             => [
                'application/json'    => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'   => Felhasznalok::class,
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class'    => Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => ['cartango@cartango.hu' => 'CARTANGO'],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'         => $db,
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'showScriptName'      => false,
            'enableStrictParsing' => false,
            'rules'               => [
                'admin'                                  => 'admin/index',
                'admin/<action:\w+>'                     => 'admin/index/<action>',
                'admin/RemoveFelhasznalo/<id:\d+>'       => 'admin/index/remove-felhasznalo',
                'admin/RemoveFelhasznaloiJogok/<id:\d+>' => 'admin/index/remove-felhasznaloi-jogok',
                'admin/RemoveMenu/<id:\d+>'              => 'admin/index/remove-menu',
                'auto/<id:[a-z0-9\-]+>'                  => 'index/auto',
            ],
        ],
        'i18n' => [
            'translations' => [
                // csak az “app” kategóriát fordítjuk
                'app*' => [
                    'class'          => PhpMessageSource::class,
                    'basePath'       => '@app/messages',
                    'sourceLanguage' => 'hu',
                    'fileMap'        => [
                        'app' => 'app.php',
                    ],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // vagy PhpManager
        ],
    ],
    'modules' => [
        'admin' => [
            'class'        => Admin::class,
            'defaultRoute' => 'index',
            'layoutPath'   => '@app/views/layouts',
            'layout'       => 'admin-main',
        ],
        'karbantartas' => [
            'class'        => Karbantartas::class,
            'defaultRoute' => 'index',
            'layoutPath'   => '@app/views/layouts',
            'layout'       => 'admin-main',
        ],
        'autok' => [
            'class'        => Autok::class,
            'defaultRoute' => 'index',
            'layoutPath'   => '@app/views/layouts',
            'layout'       => 'admin-main',
        ],
        'home' => [
            'class'        => Home::class,
            'defaultRoute' => 'index',
            'layoutPath'   => '@app/views/layouts',
            'layout'       => 'admin-main',
        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    //    $config['bootstrap'][] = 'debug';
    //    $config['modules']['debug'] = [
    //        'class' => 'yii\debug\Module',
    //        // uncomment the following to add your IP if you are not connecting from localhost.
    //        //'allowedIPs' => ['127.0.0.1', '::1'],
    //    ];

    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
