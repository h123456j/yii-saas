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
 * @controller-name 用户登录
 */
class LoginController extends BaseController
{
    /**
     * @api-name 用户登录
     * @api-method POST
     * @api-url api/login
     * @api-param string $username
     * @pai-param string $password
     * @api-response {
     * }
     */
    public function actionLogin()
    {

    }

}