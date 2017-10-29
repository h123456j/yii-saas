<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/29
 * Time: 17:16
 */

namespace app\assets;


class DateTimePickerAsset extends BaseAssetBundle
{

    public $css=[
        'static/datetimepicker/css/bootstrap-datetimepicker.min.css'
    ];

    public $js=[
        'static/datetimepicker/js/bootstrap-datetimepicker.min.js',
        'static/datetimepicker/js/init.js'
    ];

}