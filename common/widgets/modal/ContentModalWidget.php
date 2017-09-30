<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/30
 * Time: 16:41
 */

namespace common\widgets\modal;


use yii\bootstrap\Widget;

class ContentModalWidget extends Widget
{

    public $title='页面标题';

    public function run()
    {
        return $this->render('content-modal',['title'=>$this->title]);
    }

}