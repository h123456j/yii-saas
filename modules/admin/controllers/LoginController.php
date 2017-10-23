<?php

namespace backend\controllers;

use common\error\Error;
use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use yii\helpers\Url;

/**
 * 后台登录控制器
 * @author longfei <phphome@qq.com>
 */
class LoginController extends BaseController
{

    public function behaviors()
    {
        return [];
    }

    public $layout = '/admin/login';
    public $enableCsrfValidation = false;
    public $defaultAction = 'login';

    /**
     * ---------------------------------------
     * 登录页
     * ---------------------------------------
     */
    public function actionLogin()
    {
        if (! Yii::$app->user->isGuest)
            return $this->redirect(['/admin/index']);

        $model = new LoginForm();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post(), 'info') && $model->login()) {
                return self::success('登录成功');
            } else {
                return self::error(Error::COMMON_PARAM_INVALID,'用户名或密码不存在');
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * ---------------------------------------
     * 注销页
     * ---------------------------------------
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Url::toRoute('/admin/login'));
    }
}
