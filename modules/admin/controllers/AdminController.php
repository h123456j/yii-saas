<?php

namespace backend\controllers;

use app\component\helpers\Util;
use app\component\model\Page;
use app\services\admin\AdminService;
use app\services\admin\UserService;
use Yii;
use backend\models\Admin;
use yii\data\Pagination;
use yii\helpers\VarDumper;


class AdminController extends BaseController
{

    /**
     * 管理员列表
     * @param int $page
     * @param int $pageSize
     * @return string
     */
    public function actionList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('管理员列表');
        $pager = new Page($page, $pageSize);
        $data = AdminService::instance()->getAdminList($pager);
        $pagination = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('list', ['data' => $data, 'pages' => $pagination]);
    }

    public function actionUpdate($id = null)
    {
        $this->layout = '/admin/simple';
        $adminUser = new Admin();
        $adminService = AdminService::instance();
        if (!is_null($id))
            $adminUser = $adminService->getAdminInfoById($id);
        if (is_null($adminUser))
            return self::systemError();
        if (Yii::$app->request->getIsPost()) {
            $data = Yii::$app->request->post('Admin');
            Util::trim($data);
            $adminUser->tempPassword = $data['tempPassword'];
            $adminUser->setAttributes($data, false);
            $result = $adminService->updateAdmin($adminUser);
            if (is_null($result))
                return self::error();
            return self::success('操作成功');
        }
        $groupList = [];
        $data = UserService::instance()->getUserGroupList(new Page(1, 100));
        if (empty($data))
            return self::systemError();
        foreach ($data as $item) {
            $groupList[$item['group_id']] = $item['title'];
        }
        return $this->render('update', ['data' => $adminUser, 'groupList' => $groupList]);
    }

    public function actionDel()
    {
        $uid = Yii::$app->request->post('uid');
        $result = AdminService::instance()->delAdminInfo($uid);
        if (is_null($result))
            return self::error();
        return self::success('删除成功');
    }

}
