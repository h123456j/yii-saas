<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use app\assets\BaseAssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class LayoutAsset extends BaseAssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [
        'static/global/css/components-md.min.css',
        'static/global/css/plugins-md.min.css',
        'static/layouts/layout/css/layout.css',
        'static/layouts/layout/css/themes/dark-blue.css',
    ];
    /* 全局JS文件 */
    public $js = [
        'static/layouts/layout/scripts/layout.js',
        'static/layouts/layout/scripts/demo.js',
        'static/layouts/global/scripts/quick-sidebar.min.js',
        'static/other/js/common.js'
    ];
    /* 选项 */
    //public $jsOptions = ['condition' => 'lt IE9'];
    /* 依赖关系 */
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
