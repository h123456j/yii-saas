<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/22
 * Time: 21:35
 */

namespace backend\controllers;


class AppointmentController extends BaseController
{

    public function actionIndex()
    {
        $this->setPageTitle('预约模块');
        return $this->render('/common');
    }

    public function actionBridgeLoadList()
    {
        return $this->render('bridge-list');
    }

}