<?php

namespace backend\controllers;

use Yii;

/**
 * 公共调用处理
 * @author longfei <phphome@qq.com>
 */
class PublicController extends BaseController
{

    public function behaviors()
    {
        return [];
    }

    /** @var bool */
    public $layout = false;

    /** @var bool */
    public $enableCsrfValidation = false;

    /**
     * ---------------------------------------
     * 通用的404错误处理
     * @return string
     * ---------------------------------------
     */
    public function action404()
    {
        return $this->render('404');
    }

    public function actionNoAuth()
    {
        return $this->render('no_auth');
    }

    public function action50x($message='服务出错')
    {
        return $this->render('error',['message'=>$message]);
    }

}
