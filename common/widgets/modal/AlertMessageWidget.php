<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/22
 * Time: 20:45
 */

namespace common\widgets\modal;


use yii\bootstrap\Widget;

class AlertMessageWidget extends Widget
{

    public $title='消息提示';

    public function run()
    {
        return $this->render('alert-modal',['title'=>$this->title]);
    }

}