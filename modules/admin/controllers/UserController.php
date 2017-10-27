<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/27
 * Time: 23:57
 */

namespace backend\controllers;


class UserController extends BaseController
{

    public function actionIndex()
    {
        $this->setPageTitle('用户中心');
        return $this->render('/common');
    }

}