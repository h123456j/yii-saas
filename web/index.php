<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');
defined('YII_MODULE') or define('YII_MODULE','frontend');
defined('_UPLOAD_ROOT_') or  define('_UPLOAD_ROOT_',__DIR__.'/uploads');
defined('_STATIC_ROOT_') or  define('_STATIC_ROOT_',__DIR__.'/static');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = require(__DIR__ . '/../config/main.php');

defined('YII_REQUEST_START_TIME') or define('YII_REQUEST_START_TIME','');

try {
    $webApplication=(new \yii\web\Application($config));

    $webApplication->on($webApplication::EVENT_BEFORE_REQUEST, function(){
        Yii::beginProfile('REQUEST-'.Yii::$app->request->getPathInfo().'-'.YII_REQUEST_START_TIME);
    });

    $webApplication->on($webApplication::EVENT_AFTER_REQUEST, function(){
        Yii::endProfile('REQUEST-'.Yii::$app->request->getPathInfo().'-'.YII_REQUEST_START_TIME);
    });

    $webApplication->run();

} catch (Exception $e) {
    echo $e->getMessage();
}