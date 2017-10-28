<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/22
 * Time: 14:57
 */

namespace backend\controllers;


use app\component\model\Page;
use app\services\admin\MenuService;
use app\services\admin\UserService;
use backend\models\Menu;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class MenuController extends BaseController
{

    /**
     * @auth_route menu/list
     * @return string
     */
    public function actionList()
    {
        $this->setPageTitle('导航栏列表');
        $result = MenuService::instance()->getMenuList();
        return $this->render('list', ['data' => $result]);
    }

    public function actionUpdate($id = null, $pid = 0)
    {
        $this->layout = '/admin/simple';
        $menuService = MenuService::instance();
        $menuInfo = new Menu();
        $userService = UserService::instance();
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('Menu');
            $data['sort'] = (int)$data['sort'];
            $data['pid'] = (int)$data['pid'];
            if (!empty($data['id']))
                $menuInfo = $menuService->getMenuById($id);
            $menuInfo->setAttributes($data, false);
            $result = MenuService::instance()->update($menuInfo);
            if (is_null($result))
                return self::error();
            return self::success('操作成功');
        }
        if (!is_null($id)) {
            $menuInfo = $menuService->getMenuById($id);
            if (!empty($menuInfo)) {
                $menuGroupList = $userService->getGroupListByIds($menuInfo->group_id);
                if (!empty($menuGroupList)) {
                    $temp = ArrayHelper::getColumn($menuGroupList, 'title');
                    $menuInfo->groupList = implode(',', $temp);
                }
                $pid = (int)$menuInfo->pid;
            }
        }
        if ($pid > 0) {
            $parentInfo = $menuService->getMenuById($pid);
            if (!empty($parentInfo)) {
                $menuInfo->parentDesc = $parentInfo->title;
                $menuInfo->pid = $pid;
            }
            if (!empty($parentInfo->group_id)) {
                $groupList = $userService->getGroupListByIds($parentInfo->group_id);
            } else {
                $groupList = $userService->getUserGroupList(new Page(1, 100));
            }
        } else {
            $groupList = $userService->getUserGroupList(new Page(1, 100));
        }
        return $this->render('update', ['menu' => $menuInfo, 'groupList' => $groupList]);
    }

    public function actionDel()
    {
        $id=\Yii::$app->request->post('id');
        $result=MenuService::instance()->treeDel($id);
        if(is_null($result))
            return self::error();
        return self::success('删除成功');
    }


}