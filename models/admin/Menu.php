<?php

namespace backend\models;

use Yii;
use common\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Menu extends \app\models\table\Menu
{

    const MENU_ACTIVE='active';
    /**
     * 配置model规则
     */
    public function rules()
    {
        return [
            [['title', 'url'], 'required'],
            [['pid', 'sort', 'hide', 'status'], 'integer'],
            [['title', 'group'], 'string', 'max' => 50],
            [['url'], 'string', 'max' => 255]
        ];
    }

    /**
     * 获取用户导航列表
     * @param string $module
     * @param string $controller
     * @param string $action
     * @return array
     */
    public static function getMenus($module='admin',$controller='index',$action='index')
    {
        $rule=$controller.'/'.$action;
        $groupName = Yii::$app->user->identity->groupName;
        $groupId = Yii::$app->user->identity->group_id;
        $data=[];
        $menuList=static::find()->where(['hide'=>0,'status'=>1])->asArray(true)->all();
        if(!empty($menuList)){
            $tempMenuList=[];
            $current=[];
            //非超级管理员权限过滤
            if($groupName !=Admin::SYSTEM_GROUP_NAME){
                foreach($menuList as $item){

                    if($item['pid']==0){
                        $pos=strpos($item['url'],$controller);
                        if( $pos ===0){
                            $item['class']=self::MENU_ACTIVE;
                            $current=$item;
                        }
                    }else if($rule==trim($item['url'])){
                        $item['class']=self::MENU_ACTIVE;
                    }

                    $temp=explode(',',$item['group_id']);
                    if($item['group_id'] ==0 || in_array($groupId,$temp))
                        $tempMenuList[$item['pid']][]=$item;
                }
            }else{
                foreach($menuList as $item){
                    if($item['pid']==0){
                        $pos=strpos($item['url'],$controller);
                        if( $pos ===0){
                            $item['class']=self::MENU_ACTIVE;
                            $current=$item;
                        }
                    }else if($rule==trim($item['url'])){
                        $item['class']=self::MENU_ACTIVE;
                    }

                    $tempMenuList[$item['pid']][]=$item;
                }
            }

            //一级菜单处理
            if(!empty($tempMenuList[0])){
                $data['main']=$tempMenuList[0];
                //排序处理
                ArrayHelper::multisort($data['main'],'sort',SORT_ASC);
                unset($tempMenuList[0]);
                //二级菜单
                $secondMenuList=[];
                if(isset($current['id']) && !empty($tempMenuList[$current['id']])){
                    $secondMenuList=$tempMenuList[$current['id']];
                    //排序处理
                    ArrayHelper::multisort($secondMenuList,'sort',SORT_ASC);
                    unset($tempMenuList[$current['id']]);
                }
                //三级菜单
                if(!empty($secondMenuList)){
                    foreach($secondMenuList as $key=>$item){
                        if(isset($tempMenuList[$item['id']])){
                            $childList=$tempMenuList[$item['id']];
                            //排序处理
                            ArrayHelper::multisort($childList,'sort',SORT_ASC);
                            $secondMenuList[$key]['_child']=$childList;
                            //点亮二级节点
                            foreach($childList as $v){
                                if(isset($v['class']))
                                    $secondMenuList[$key]['class']=self::MENU_ACTIVE;
                            }
                        }
                    }
                }
                $data['child']=$secondMenuList;
            }
        }
        return $data;
    }

}
