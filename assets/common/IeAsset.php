<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets\common;

use app\assets\BaseAssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class IeAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    /* 全局CSS文件 */
    public $css = [
    ];
    /* 全局JS文件 */
    public $js = [
        'static/global/plugins/respond.min.js',
        'static/global/plugins/excanvas.min.js',
    ];
    /* 选项 */
    public $jsOptions = ['condition' => 'lt IE9'];

}
