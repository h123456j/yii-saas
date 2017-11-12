<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/29
 * Time: 14:09
 */

namespace common\widgets\common;


use yii\bootstrap\Widget;

class OperateWidget extends Widget
{

    public $createParams=[];

    public $updateParams=[];

    public $lookParams=[];

    public $delParams=[];

    public function run()
    {
        return $this->render('operate',[
            'create'=>$this->createParams,
            'update'=>$this->updateParams,
            'look'=>$this->lookParams,
            'del'=>$this->delParams
        ]);
    }


}