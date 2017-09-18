<?php

namespace backend\controllers;

use app\common\core\Controller;
use Yii;

/**
 * 公共调用处理
 * @author longfei <phphome@qq.com>
 */
class PublicController extends Controller
{

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

}
