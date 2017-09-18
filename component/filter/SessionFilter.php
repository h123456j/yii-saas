<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/12
 * Time: 17:11
 */

namespace app\component\filter;


use yii\base\ActionFilter;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class SessionFilter extends ActionFilter
{

    public function beforeAction($action)
    {
        return $this->filterSession();
    }

    private function filterSession()
    {
        /* 判断是否登录 */
        if (\Yii::$app->user->getIsGuest()){
            return \Yii::$app->response->redirect(Url::to(['/admin/login']));
        }
        return true;
    }

}