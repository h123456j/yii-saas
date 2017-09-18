<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [
        'static/global/plugins/font-awesome/css/font-awesome.min.css',
        'static/global/plugins/simple-line-icons/simple-line-icons.min.css',
        'static/global/plugins/bootstrap/css/bootstrap.min.css',
        'static/other/css/style.css',
        'static/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css',
    ];
    /* 全局JS文件 */
    public $js = [
        'static/global/plugins/jquery.min.js',
        'static/global/plugins/js.cookie.min.js',
        'static/global/plugins/bootstrap/js/bootstrap.min.js',
        'static/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        'static/global/plugins/jquery-slim-scroll/jquery.slimscroll.min.js',
        'static/global/plugins/jquery.block-ui.min.js',
        'static/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js',
        'static/global/scripts/app.js',
    ];

    /* 依赖关系 */
    public $depends = [
        'app\assets\common\IeAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    /**
     * ------------------------------------------
     * 定义按需加载JS方法，注意加载顺序在最后
     * @param $view \yii\web\View
     * @param $jsfile string
     * ------------------------------------------
     */
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }

    /**
     * ------------------------------------------
     * 定义按需加载css方法，注意加载顺序在最后
     * @param $view \yii\web\View
     * @param $cssfile string
     * ------------------------------------------
     */
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [AppAsset::className(), 'depends' => 'backend\assets\AppAsset']);
    }
}
