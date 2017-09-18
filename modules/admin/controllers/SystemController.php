<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/9/16
 * Time: 11:30
 */

namespace backend\controllers;

/**
 * 系统设置模块
 * Class SystemController
 * @package backend\controllers
 */
class SystemController extends BaseController
{
    /**
     * @auth_route system/index
     * @return string
     */
    public function actionIndex()
    {
        $this->getView()->title='系统设置';
        return $this->render('index');
    }

    /**
     * @auth_route system/group-list
     * @return string
     */
    public function actionGroupList()
    {
        $this->getView()->title='用户组列表';
        return $this->render('group_list');
    }

    /**
     * @auth_route system/menu-list
     * @return string
     */
    public function actionMenuList()
    {
        $this->getView()->title='菜单栏列表';
        return $this->render('menu_list');
    }

    /**
     * @auth_route system/user-list
     * @return string
     */
    public function actionUserList()
    {
        $this->getView()->title='管理员列表';
        return $this->render('user_list');
    }


}