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
class LoginAsset extends BaseAssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [
        'static/global/css/components-rounded.min.css',
        'static/global/css/plugins.min.css',
        'static/pages/css/login.css',
    ];
    /* 全局JS文件 */
    public $js = [
        'static/global/plugins/jquery-validation/js/jquery.validate.min.js',
        'static/global/plugins/jquery-validation/js/additional-methods.min.js',
        'static/global/plugins/select2/js/select2.full.min.js',
    ];
    /* 依赖关系 */
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
