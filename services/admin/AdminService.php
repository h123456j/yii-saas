<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/28
 * Time: 18:22
 */

namespace app\services\admin;


use app\component\helpers\Util;
use app\services\base\BaseService;
use backend\models\Admin;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class AdminService extends BaseService
{

    public function getAdminList($pager)
    {
        return Admin::getUserList($pager);
    }

    public function getAdminInfoById($id)
    {
        return Admin::findOne(['uid' => $id]);
    }

    public function updateAdmin(Admin $adminInfo)
    {
        if (empty($adminInfo->username))
            throw new Exception('管理员名称不能为空', Error::COMMON_PARAM_INVALID);
        if (empty($adminInfo->uid) && empty($adminInfo->tempPassword))
            throw new Exception('登录密码不能为空', Error::COMMON_PARAM_INVALID);

        if (empty($adminInfo->uid)) {
            $adminInfo->password=$adminInfo->tempPassword;
            $temp = Admin::findOne(['username' => $adminInfo->username]);
            if (!empty($temp))
                throw new Exception('名称已被占用', Error::COMMON_PARAM_INVALID);
            $adminInfo->generateAuthKey();
            $adminInfo->setPassword($adminInfo->password);
            $adminInfo->reg_time = date('Y-m-d H:i:s');
            $adminInfo->reg_ip = Util::getIp(true);
            $adminInfo->create_people=\Yii::$app->user->identity->username;
        }else{
            //修改密码处理
            if(!empty($adminInfo->tempPassword)){
                $adminInfo->generateAuthKey();
                $adminInfo->setPassword($adminInfo->tempPassword);
            }
        }
        $adminInfo->update_time = date('Y-m-d H:i:s');
        return $adminInfo->save();
    }

    public function delAdminInfo($uid)
    {
        return Admin::deleteAll(['uid'=>$uid]);
    }

}