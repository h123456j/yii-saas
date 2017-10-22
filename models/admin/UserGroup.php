<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 16:49
 */

namespace backend\models;


class UserGroup extends \app\models\table\UserGroup
{

    const ACTIVE_STATUS=1;

    /**
     * 分页获取用户组
     * @param $pager
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUserGroupList($pager)
    {
        $query=static ::find()
            ->where(['status'=>1])
            ->offset($pager->getOffset())
            ->limit($pager->getLimit());
        $pager->setCount($query->count());
        return $query->all();
    }

}