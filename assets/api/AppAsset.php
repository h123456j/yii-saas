<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/3
 * Time: 21:46
 */

namespace api\assets;


use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{

    public $basePath='@webroot';
    public $baseUrl='@web';

    public $css=[
        'static/global/plugins/bootstrap/css/bootstrap.min.css'
    ];

    public $js=[
        'static/common/js/jquery.js',
        'static/global/plugins/bootstrap/js/bootstrap.min.js',
        'static/common/js/template-web.js',
        'static/common/js/api.js'
    ];
}