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
    public function getUserGroupList($pager)
    {
        return UserGroup::getUserGroupList($pager);
    }

    /**
     * 获取菜单栏树状列表
     * @return array
     */
    public function getMenuList()
    {
        $data=Menu::getMenuList();
        if(empty($data))
            return [];
        return self::getMenuTree($data);
    }

    /**
     * 组装树状节点
     * @param $data
     * @param int $pid
     * @return array
     */
    private static function getMenuTree($data,$pid=0)
    {
        $result=[];
        foreach($data as $key=>$item){
            if($item['pid']==$pid){
                unset($data[$key]);
                $item['_child']=self::getMenuTree($data,$item['id']);
                $result[]=$item;
            }
        }
        return $result;
    }

}