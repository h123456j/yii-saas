<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/20
 * Time: 14:34
 */

namespace app\services\admin;


use app\services\base\BaseService;
use backend\models\Menu;

class MenuService extends BaseService
{
    /**
     * 获取导航栏列表
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