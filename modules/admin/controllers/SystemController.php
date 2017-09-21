<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/9/16
 * Time: 11:30
 */

namespace backend\controllers;

use app\component\model\Page;
use app\services\admin\UserService;
use yii\data\Pagination;
use yii\helpers\VarDumper;

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
        $this->getView()->title = '系统设置';
        return $this->render('index');
    }

    /**
     * 用户组列表
     * @param int $page
     * @param int $pageSize
     * @return string
     */
    public function actionGroupList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->getView()->title = '用户组列表';
        $pager = new Page($page, $pageSize);
        $data = UserService::instance()->getUserGroupList($pager);
        $pagination = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('group_list',['data'=>$data,'pages'=>$pagination]);
    }

    /**
     * @auth_route system/menu-list
     * @return string
     */
    public function actionMenuList()
    {
        $this->getView()->title = '菜单栏列表';
        return $this->render('menu_list');
    }

    /**
     * 管理员列表
     * @param int $page
     * @param int $pageSize
     * @return string
     */
    public function actionUserList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->getView()->title = '管理员列表';
        $pager = new Page($page, $pageSize);
        $data = UserService::instance()->getUserList($pager);
        $pagination = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('user_list', ['data' => $data, 'pages' => $pagination]);
    }


}