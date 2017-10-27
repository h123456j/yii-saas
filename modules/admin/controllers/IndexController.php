<?php

namespace backend\controllers;

use Yii;

/**
 * 后台首页控制器
 * @author longfei <phphome@qq.com>
 */
class IndexController extends BaseController
{

    /**
     * 页面
     * @return string
     */
    public function actionIndex()
    {
        $this->setPageTitle('后台管理系统');
        return $this->render('/common');
    }

}
