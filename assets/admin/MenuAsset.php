<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/20
 * Time: 14:53
 */

namespace backend\assets;


use app\assets\BaseAssetBundle;

class MenuAsset extends BaseAssetBundle
{


    public $css=[

    ];

    public $js=[
        '/static/common/js/menu.js'
    ];

    public $depends=[
        'backend\assets\AppAsset'
    ];



}