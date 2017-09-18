<?php

namespace frontend\controllers;

use yii\web\Controller;

class IndexController extends Controller
{
    /**
     * @var string
     */
    public $layout = '/frontend/main';

    public function actionIndex()
    {
        $this->getView()->title='测试主页';
        return $this->render('index');
    }
    
}
