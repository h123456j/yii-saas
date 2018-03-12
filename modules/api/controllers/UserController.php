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
use app\component\model\Page;
use app\services\api\UserService;
use common\error\Error;
use yii\helpers\VarDumper;

/**
 * Class User
 * @package api\controllers
 * @controller-name 用户模块
 * @controller-rank 20
 */
class UserController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'session' => [
                'class' => ApiSessionFilter::className(),
                'except' => ['login', 'we-chat-login']
            ]
        ]);
    }

    /**
     * @api-name  微信授权登录
     * @api-url user/we-chat-login
     * @api-method POST
     * @api-param string $code 微信授权登录code
     * @api-response {
     *    "data":{
     *      "completeInfo": true,用户信息是否已完善(true-是 false-否)
     *      "uid": "15081455574753",用户id
     *      "sid": "31a569fbbe31a85561f1ede3f6bc750a",会话id
     *        }
     * }
     */
    public function actionWeChatLogin()
    {
        $code = \Yii::$app->request->post('code');
        if (empty($code))
            \Yii::$app->response->error(Error::COMMON_PARAM_INVALID, '参数不合法');
        $result = UserService::instance()->weChatLogin($code);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 普通登录
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
     * @api-name 完善信息
     * @api-url complete-info
     * @api-method POST
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $type 类型（1-首次完善 2-修改用户资料 默认为1）
     * @api-param string $data 提交数据（json格式：{"nickname": "用户昵称","headPhoto": "用户头像（选填）", "password": "用户密码[参数type为2是可以留空]","sex": "性别（0-保密 1-男 2-女）", "tel": "联系电话（选填）", "type": "用户类型（1-客户经理 2-内部人员 3-地产中介 4-其他）"}）
     * @api-response{
     *      "data":"true",(true-成功 false-失败)
     * }
     */
    public function actionCompleteInfo()
    {
        $type = \Yii::$app->request->post('type');
        if (empty($type))
            $type = 1;
        $data = \Yii::$app->request->post('data');
        $data = json_decode($data, true);
        if (empty($data))
            \Yii::$app->response->error(Error::COMMON_PARAM_INVALID, '参数不合法');
        $result = UserService::instance()->completeInfo($type, $data);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
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
        $result = UserService::instance()->logout();
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 用户信息
     * @api-method POST
     * @api-url user/info
     * @api-param string $uid 用户id
     * @api-param string $sid 回话id
     * @api-response {
     *     "data": {
     *       "uid": "15081455574753",用户id
     *       "nickname": "ce_shi",用户昵称
     *       "headPhoto": "",用户头像
     *       "tel": "18166044582",联系电话
     *       "sex": 1,性别
     *       "sexDesc": "先生",性别描述
     *       "type": 1,类型
     *       "typeDesc": "客户经理",类型描述
     *       }
     * }
     */
    public function actionInfo()
    {
        $result = UserService::instance()->info();
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

}