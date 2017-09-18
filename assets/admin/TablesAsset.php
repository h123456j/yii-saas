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
class TablesAsset extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [
        'static/global/plugins/data-tables/datatables.min.css',
        'static/global/plugins/data-tables/plugins/bootstrap/datatables.bootstrap.css',
    ];
    /* 全局JS文件 */
    public $js = [
        'static/global/scripts/datatable.js',
        'static/global/plugins/data-tables/datatables.min.js',
        'static/global/plugins/data-tables/plugins/bootstrap/datatables.bootstrap.js',
    ];
    /* 选项 */
    //public $jsOptions = ['condition' => 'lt IE9'];
    /* 依赖关系 */
    public $depends = [
        'backend\assets\AppAsset',
    ];
}
