<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 11:42
 */

namespace app\services\admin;

use app\component\helpers\Util;
use app\services\base\BaseService;
use backend\models\Admin;
use backend\models\Menu;
use backend\models\UserGroup;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class UserService extends BaseService
{

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

    public function getGroupInfoById($id)
    {
        return UserGroup::findOne(['group_id' => $id]);
    }

    public function groupUpdate(UserGroup $groupInfo)
    {
        if (empty($groupInfo->group_id)) {
            $temp = UserGroup::findOne(['name' => $groupInfo->name]);
            if (!empty($temp))
                throw new Exception('用户组名称已被占用', Error::COMMON_PARAM_INVALID);
            $groupInfo->create_ip = Util::getUrl(true);
            $groupInfo->create_people = \Yii::$app->user->identity->username;
            $groupInfo->create_time = date('Y-m-d H:i:s');
        }
        $groupInfo->update_time = date('Y-m-d H:i:s');
        return $groupInfo->save();
    }


}