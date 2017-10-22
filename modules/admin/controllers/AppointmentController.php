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
        return $this->render('index');
    }

}