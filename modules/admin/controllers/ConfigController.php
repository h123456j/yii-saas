<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/9/16
 * Time: 20:59
 */

namespace backend\controllers;


class ConfigController extends BaseController
{

    public function actionIndex()
    {
        $this->setPageTitle('配置模块');
        return $this->render('/common');
    }

}