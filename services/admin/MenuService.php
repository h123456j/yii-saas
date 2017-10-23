<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/20
 * Time: 14:34
 */

namespace app\services\admin;


use app\component\helpers\Util;
use app\services\base\BaseService;
use backend\models\Menu;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

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


    public function update(Menu $menu)
    {
        $menu->update_time=date('Y-m-d H:i:s');
        $transaction=$menu::getDb()->beginTransaction();
        try{
            if($menu->save()){
                if(empty($menu->pid)){
                    $menu->tree_code=$menu->id;
                }else{
                    $menu->tree_code=$menu->tree_code.$menu::TREE_CODE_SEPARATOR.$menu->id;
                }
                $menu->save();
            }
            $transaction->commit();
            return true;
        }catch (Exception $e){
            \Yii::error('数据插入失败:'.$e->getMessage());
            $transaction->rollBack();
            throw new Exception('操作失败',Error::COMMON_DB);
        }
    }

    public function getMenuById($id)
    {
        return Menu::findOne(['id'=>$id,'status'=>1]);
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
            $item['addUrl']='/admin/menu/update?pid='.$item['id'];
            $item['editUrl']='/admin/menu/update?id='.$item['id'];
            if($item['pid']==$pid){
                unset($data[$key]);
                $item['_child']=self::getMenuTree($data,$item['id']);
                $result[]=$item;
            }
        }
        return $result;
    }

}