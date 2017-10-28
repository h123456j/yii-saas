<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/28
 * Time: 23:44
 */

namespace common\widgets\common;


use yii\bootstrap\Widget;

class FormFooterWidget extends Widget
{

    public $closeTitle='关&nbsp;闭';
    public $submitTitle='提&nbsp;交';

    public function run()
    {
        return $this->render('form-footer',[
            'closeTitle'=>$this->closeTitle,
            'submitTitle'=>$this->submitTitle
        ]);
    }

}