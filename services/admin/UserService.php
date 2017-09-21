<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 11:42
 */

namespace app\services\admin;


use app\services\base\BaseService;
use backend\models\Admin;
use backend\models\UserGroup;

class UserService extends BaseService
{

    /**
     * 分页获取管理员列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUserList($pager)
    {
        return Admin::getUserList($pager);
    }

    /**
     * 分页获取用户组数据
     * @param $pager
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getUserGroupList($pager)
    {
        return UserGroup::getUserGroupList($pager);
    }

}