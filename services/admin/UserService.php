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
use backend\models\Menu;
use backend\models\UserGroup;
use yii\helpers\VarDumper;

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
    public function getUserGroupList($pager, $index = null)
    {
        $data = UserGroup::getUserGroupList($pager);
        if (is_null($index) || empty($data))
            return $data;
        $list = [];
        foreach ($data as $item) {
            $list[$item->$index] = $item;
        }
        return $list;
    }

    public function getGroupListByIds($ids = [])
    {
        if (!is_array($ids))
            $ids = explode(',', $ids);
        return UserGroup::find()
            ->select('*')
            ->where(['status' => 1])
            ->andWhere(['in', 'group_id', $ids])
            ->all();
    }


}