<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/3
 * Time: 10:47
 */

namespace api\controllers;


use app\component\controller\BaseController;

/**
 * Class LoginController
 * @package api\controllers
 *
 * @controller-name 登录模块
 */
class LoginController extends BaseController
{

    /**
     * @api-name 用户登录
     * @api-url login/login
     * @api-method POST
     * @api-param string username 用户名
     * @api-param string password 用户密码
     * @api-response {
     * }
     */
    public function actionLogin()
    {

    }

    /**
     * @api-name 退出登录
     * @api-url login/logout
     * @api-method POST
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-response{
     *      "data":"1",(1-成功 0-失败)
     * }
     */
    public function actionLogout()
    {

    }

}