<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 19:22
 */

namespace app\services\api;


use app\component\helpers\Util;
use app\component\session\SessionContainer;
use app\models\Message;
use app\models\UserInfo;
use app\services\base\BaseService;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class UserService extends BaseService
{

    private static $weChartLoginUrl = 'https://api.weixin.qq.com/sns/jscode2session';//微信授权登录

    /**
     * 微信授权登录
     * @param $code
     * @return array
     * @throws Exception
     */
    public function weChatLogin($code)
    {
        $weChartConfig = \Yii::$app->params['we-chart'];
        $params = [
            'appid' => $weChartConfig['appid'],
            'SECRET' => $weChartConfig['secret'],
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];

        $result = \Yii::$app->curl->get(self::$weChartLoginUrl, $params);
        if (isset($result['errcode']))
            throw  new  Exception($result['errmsg'], $result['errcode']);

        $openid = $result['openid'];
        $sessionKey = $result['session_key'];
//        $unionid=$result['unionid'];

        $userInfo = UserInfo::findOne(['openid' => $openid]);
        $completeInfo = true;
        if (empty($userInfo)) {
            $completeInfo = false;
            $userInfo = new UserInfo();
            $userInfo->uid = Util::generateUid();
            $userInfo->openid = $openid;
            $userInfo->reg_time = date('Y-m-d H:i:s');
            $userInfo->reg_id = ip2long(Util::getIp());
        }
        $userInfo->last_login_time = $userInfo->update_time = date('Y-m-d H:i:s');
        $userInfo->last_login_ip = ip2long(Util::getIp());
        $transaction = $userInfo::getDb()->beginTransaction();
        try {
            $userInfo->save();
            \Yii::$app->session->writeSession($userInfo->uid, $sessionKey);
            $transaction->commit();
            return [
                'completeInfo' => $completeInfo,
                'uid' => $userInfo->uid,
                'sid' => $sessionKey
            ];
        } catch (\Exception $e) {
            \Yii::error("数据库错误" . $e->getCode() . '=>' . $e->getMessage());
            $transaction->rollBack();
            throw  new  Exception('数据库错误', Error::COMMON_DB);
        }
    }

    public function info($scenario = 'info')
    {
        $userInfo = UserInfo::findOne(['uid' => SessionContainer::getUid()]);
        if (!empty($userInfo))
            $userInfo->setScenario($scenario);
        return $userInfo;
    }

    public function logout()
    {
        return \Yii::$app->session->destroySession(SessionContainer::getUid());
    }


    public function completeInfo($type, $data)
    {
        $userInfo = UserInfo::findOne(['uid' => SessionContainer::getUid()]);
        if (empty($userInfo))
            throw  new Exception('用户不存在', Error::USER_INFO_IS_EMPTY);

        if (empty($data['nickname']))
            throw  new  Exception('昵称不能为空', Error::USER_NICKNAME_IS_INVALID);

        $data['password'] = isset($data['password']) ? trim($data['password']) : '';
        if ($type == 1 && strlen($data['password']) < 6)
            throw  new Exception('密码长度不合法', Error::USER_PASSWORD_IS_INVALID);

        if (isset($data['type']) && !in_array($data['type'], UserInfo::$userType))
            throw  new  Exception('用户类型不存在', Error::USER_TYPE_IS_INVALID);

        if (!UserInfo::checkNickname($userInfo->uid, $data['nickname']))
            throw  new Exception('昵称已被占用', Error::USER_NICKNAME_IS_INVALID);

        $userInfo->nickname = $data['nickname'];
        $userInfo->head_photo = $data['headPhoto'];
        if ($type == 1) {
            $userInfo->salt = Util::generateSalt();
            $userInfo->password = Util::generatePassword($data['password'], $userInfo->salt);
        }
        $userInfo->tel = $data['tel'];
        $userInfo->sex = $data['sex'];
        $userInfo->type = $data['type'];
        $userInfo->update_time = date('Y-m-d H:i:s');
        return $userInfo->save();
    }

    public function getMessageList($cate, $pager, $scenario = 'list')
    {
        switch ($cate) {
            case 1:
                $cate = [Message::TYPE_FOR_COMMON];
                break;
            case  2:
                $cate = [Message::TYPE_FOR_APPOINTMENT, Message::TYPE_FOR_ESTATE_AUDIT];
                break;
            default:
                $cate = null;
                break;
        }
        $data = Message::getMessageList(SessionContainer::getUid(), $pager, $cate, $scenario);
        return [
            'page' => $pager,
            'items' => $data
        ];
    }

    public function getMessageInfo($id, $scenario = 'info')
    {
        $messageInfo = Message::findOne(['id' => $id]);
        if (!empty($messageInfo)) {
            $messageInfo->setScenario($scenario);
            Message::updateAll(['status' => 1], ['id' => $id]);
        }
        return $messageInfo;
    }

    public function getAppointmentList($cate,$pager,$scenario='list')
    {
        switch($cate){
            case 1:
                break;
            case  2:
                break;
            case  3:
                break;
            case  4:
                break;
            default:
                break;
        }
    }

}