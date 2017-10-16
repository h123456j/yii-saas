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

    /**
     * @api-name 我的消息
     * @api-method POST
     * @api-url user/message-list
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $cate 消息类别（1-文章消息；2-业务消息 默认所有）
     * @api-param int $page 页码（选填）
     * @api-param int $pageSize 每页数量（选填）
     * @api-response {
     *       "data": {
     *          "page": {
     *             "current": 1,
     *             "total": 1,
     *             "count": 2,
     *             "size": 20
     *           },
     *        "items": [
     *             {
     *          "id": 2,记录id
     *          "title": "预约反馈",消息标题
     *          "createTime": "2017-10-16 19:59:29",创建时间
     *          "type": 3,类型
     *          "typeDesc": "预约反馈",类型描述
     *          "status": 0,状态（0-未读 1-已读）
     *            },
     *         ...
     *        ]
     *    }
     * }
     */
    public function actionMessageList()
    {
        $cate = \Yii::$app->request->post('cate');
        $page = \Yii::$app->request->post('page');
        $pageSize = \Yii::$app->request->post('pageSize');
        $pager = new Page($page, $pageSize);
        $result = UserService::instance()->getMessageList($cate, $pager);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 消息详情
     * @api-url user/message-info
     * @api-method POST
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $id 消息id
     * @api-response{
     *    "data": {
     *       "id": 1,记录id
     *      "title": "发表文章",消息标题
     *      "createTime": "2017-10-16 19:58:38",创建时间
     *      "content": "测试文章发布消息",消息内容
     *       }
     * }
     */
    public function actionMessageInfo()
    {
        $id = \Yii::$app->request->post('id');
        $id = 1;
        if (empty($id))
            \Yii::$app->response->error('参数不合法', Error::COMMON_PARAM_INVALID);
        $result = UserService::instance()->getMessageInfo($id);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
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
        $cate = (int)\Yii::$app->request->post('cate');
        $page = \Yii::$app->request->post('page');
        $pageSize = \Yii::$app->request->post('pageSize');
        $pager = new Page();
        $result = UserService::instance()->getAppointmentList($cate, $pager);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

}