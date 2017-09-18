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
class Select2Asset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [
        'static/global/plugins/select2/css/select2.min.css',
        'static/global/plugins/select2/css/select2-bootstrap.min.css',
    ];
    /* 全局JS文件 */
    public $js = [
        'static/global/plugins/select2/js/select2.full.min.js',
        'static/pages/scripts/components-select2.min.js',
    ];
    /* 依赖关系 */
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
