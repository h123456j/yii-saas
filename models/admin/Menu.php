<?php

namespace backend\models;

use Yii;
use common\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class Menu extends \app\models\table\Menu
{

    const MENU_ACTIVE = 'active';
    const MENU_HIDE_STATUS = 0;
    const MENU_STATUS_ACTIVE = 1;
    const TREE_CODE_SEPARATOR='-';


    private static $menuList = [];

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
     * 获取导航栏列表数据
     * @return array
     */
    public static function getMenus()
    {
        $groupName = Yii::$app->user->identity->groupName;
        $groupId = Yii::$app->user->identity->group_id;

        $data = [];
        $treeCode = Yii::$app->request->get('menuTreeCode');
        if (empty($treeCode)) {
            $temp = self::find()->where(['pid' => 0, 'hide' => 0, 'status' => 1])->orderBy(['sort' => SORT_ASC])->one();
            if (empty($temp))
                exit('<h1 style="text-align: center;margin-top: 50px;">导航栏获取失败</h1>');
            $treeCode = $temp->tree_code;
        }
        $treeCode = explode(self::TREE_CODE_SEPARATOR, $treeCode);
        self::$menuList = static::find()->where(['hide' => 0, 'status' => 1])->orderBy(['sort' => SORT_ASC])->asArray(true)->all();

        if (!empty(self::$menuList)) {
            //非超级管理员权限过滤处理
            if ($groupName != Admin::SYSTEM_GROUP_NAME) {
                foreach (self::$menuList as $key=>&$item) {
                    $temp = explode(',', $item['group_id']);
                    if ($item['group_id'] == 0 || in_array($groupId, $temp)) {
                        $item['url'] = self::dealUrl($item['url'], $item['tree_code']);
                        if (in_array($item['id'], $treeCode)) {
                            $item['class'] = self::MENU_ACTIVE;
                            $current = $item['pid'] == 0 ? $item : [];
                        }
                        if ($item['pid'] == 0) {
                            $data['main'][] = $item;
                            unset(self::$menuList[$key]);
                        }
                    }
                }
            } else {
                foreach (self::$menuList as $key => &$item) {
                    $item['url'] = self::dealUrl($item['url'], $item['tree_code']);
                    if (in_array($item['id'], $treeCode)) {
                        $item['class'] = self::MENU_ACTIVE;
                        $current = $item['pid'] == 0 ? $item : [];
                    }
                    if ($item['pid'] == 0) {
                        $data['main'][] = $item;
                        unset(self::$menuList[$key]);
                    }

                    $codes=explode(self::TREE_CODE_SEPARATOR,$item['tree_code']);
                    $temp=array_intersect($codes,$treeCode);
                    if(empty($temp))
                        unset(self::$menuList[$key]);
                }
            }

            if(isset($current['id']))
                $data['_child']=self::menuTree($current['id']);
        }
        return $data;
    }


    protected static function menuTree($pid=0)
    {
        $result=[];
        foreach(self::$menuList as $key=>$item){
            if($item['pid']==$pid){
                unset(self::$menuList[$key]);
                $item['_child']=self::menuTree($item['id']);
                $result[]=$item;
            }
        }
        return $result;
    }


    /**
     * 获取菜单栏列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMenuList()
    {
        return static::find()->where(['status' => self::MENU_STATUS_ACTIVE, 'hide' => self::MENU_HIDE_STATUS])->asArray(true)->all();
    }

    /**
     * 处理导航栏url
     * @param $url
     * @param $treeCode
     * @return string
     */
    protected static function dealUrl($url, $treeCode)
    {
        $url = trim($url);
        if (empty($url))
            return null;
        return strpos($url, '?') === false ? $url . '?menuTreeCode=' . $treeCode : '&menuId=' . $treeCode;
    }

}
