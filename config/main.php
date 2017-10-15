<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/12
 * Time: 13:00
 */

$component = require(__DIR__ . '/' . YII_MODULE . '/component.php');
$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'yii-admin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => array_merge($component, [
        'request' => [
            'class' => 'common\core\Request',
            'cookieValidationKey' => '123456',
        ],
        'response' => [
            'class' => 'common\core\Response',
            'errorManager' => 'errorManager'
        ],
        'curl'=>[
            'class'=>'app\component\http\Curl',
            'options'=>[]
        ],
        'session'=>[
            'class'=>'app\component\session\BaseSession'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'errorManager' => [
            'class' => 'app\component\exception\ErrorManager'
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => false,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/url.php')
        ],
    ]),
    'modules' => [
        'admin' => 'app\modules\admin\Module',
        'api' => 'app\modules\api\Module',
        'frontend' => 'app\modules\frontend\Module'
    ],
    'params' => $params,
];

if (!YII_ENV_PROD) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['doc'] = [
        'class' => 'app\modules\doc\Module'
    ];

    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}
return $config;