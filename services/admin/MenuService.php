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
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class MenuService extends BaseService
{
    /**
     * 获取导航栏列表
     * @return array
     */
    public function getMenuList()
    {
        $data = Menu::getMenuList();
        if (empty($data))
            return [];
        return self::getMenuTree($data);
    }


    public function update(Menu $menu)
    {
        $menu->update_time = date('Y-m-d H:i:s');
        $transaction = $menu::getDb()->beginTransaction();
        try {
            if ($menu->pid > 0 && empty($menu->group_id)) {
                $temp = Menu::findOne(['id' => $menu->pid]);
                if (empty($temp))
                    throw new Exception('数据库错误', Error::COMMON_DB);
                $menu->group_id = $temp->group_id;
                $menu->tree_code = $temp->tree_code;
            }

            if ($menu->save()) {
                if (empty($menu->pid)) {
                    $treeCode = $menu->id;
                } elseif (empty($menu->tree_code)) {
                    $treeCode = $menu->pid . $menu::TREE_CODE_SEPARATOR . $menu->id;
                } else {
                    $temp = explode($menu::TREE_CODE_SEPARATOR, $menu->tree_code);
                    if (!in_array($menu->id, $temp))
                        $treeCode = $menu->tree_code . $menu::TREE_CODE_SEPARATOR . $menu->id;
                }
                if (!empty($treeCode))
                    Menu::updateAll(['tree_code' => $treeCode], ['id' => $menu->id]);
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            \Yii::error('数据插入失败:' . $e->getMessage());
            $transaction->rollBack();
            throw new Exception('操作失败', Error::COMMON_DB);
        }
    }

    public function getMenuById($id)
    {
        return Menu::findOne(['id' => $id, 'status' => 1]);
    }

    /**
     * 组装树状节点
     * @param $data
     * @param int $pid
     * @return array
     */
    private static function getMenuTree($data, $pid = 0)
    {
        $result = [];
        foreach ($data as $key => $item) {
            $item['addUrl'] = '/admin/menu/update?pid=' . $item['id'];
            $item['editUrl'] = '/admin/menu/update?id=' . $item['id'];
            if ($item['pid'] == $pid) {
                unset($data[$key]);
                $item['_child'] = self::getMenuTree($data, $item['id']);
                $result[] = $item;
            }
        }
        return $result;
    }

    public function treeDel($id)
    {
        $menuList = Menu::find()
            ->select('id')
            ->where(['like', 'tree_code', $id])
            ->all();
        $ids = ArrayHelper::getColumn($menuList, 'id');
        return Menu::deleteAll(['in', 'id', $ids]);
    }

}