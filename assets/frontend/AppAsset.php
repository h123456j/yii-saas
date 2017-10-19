<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use app\assets\BaseAssetBundle;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends BaseAssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    /* 全局CSS文件 */
    public $css = [

    ];
    /* 全局JS文件 */
    public $js = [

    ];
    public $depends = [

    ];
}
