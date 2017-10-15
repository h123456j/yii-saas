<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 16:17
 */

namespace api\controllers;


use app\component\controller\BaseController;
use app\component\filter\ApiSessionFilter;
use yii\helpers\VarDumper;

/**
 * Class User
 * @package api\controllers
 * @controller-name 用户模块
 */
class UserController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
            'session'=>[
                'class'=>ApiSessionFilter::className(),
                'except'=>['login','we-chat-login']
            ]
        ]);
    }

    /**
     * @api-name  微信授权登录
     * @api-url user/we-chat-login
     * @api-method POST
     * @api-param string $code 微信授权登录code
     * @api-response {
     * }
     */
    public function actionWeChatLogin()
    {

    }

    /**
     * @api-name 用户登录
     * @api-url user/login
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
     * @api-url user/logout
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

    /**
     * @api-name 用户信息
     * @api-method POST
     * @api-url user/info
     * @api-param string $uid 用户id
     * @api-param string $sid 回话id
     * @api-response {
     * }
     */
    public function actionInfo()
    {

    }

    /**
     * @api-name 我的消息
     * @api-method POST
     * @api-url user/message-list
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $cate 消息类别（1-文章消息；2-业务消息）
     * @api-param int $page 页码（选填）
     * @api-param int $pageSize 每页数量（选填）
     * @api-response {
     * }
     */
    public function actionMessageList()
    {

    }

    /**
     * @api-name 我的预约
     * @api-method POST
     * @api-url user/appointment-list
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $cate 预约类别（0-all；1-过桥预约；2-物业预约；3-赎楼预约；4-其他预约；默认为0）
     * @api-param int $page 页码（选填）
     * @api-param int $pageSize 分页数（选填）
     * @api-response {
     * }
     */
    public function actionAppointmentList()
    {

    }

}