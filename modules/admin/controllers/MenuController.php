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
use yii\helpers\VarDumper;

class MenuController extends BaseController
{

    /**
     * @auth_route menu/list
     * @return string
     */
    public function actionList()
    {
        $this->getView()->title = '导航栏列表';
        $result=MenuService::instance()->getMenuList();
        return $this->render('list',['data'=>$result]);
    }

    public function actionUpdate($id=null,$pid=0)
    {
        $this->layout='/admin/simple';
        $menu=new Menu();
        $menuService=MenuService::instance();
        if(!is_null($id))
            $menu=$menuService->getMenuById($id);

        \Yii::$app->response->redirect(['/admin/public/50x','message'=>'数据查询失败']);
        if($pid>0){
            $menuInfo=$menuService->getMenuById($pid);
        }

        if(\Yii::$app->request->getIsPost()){
            $data=\Yii::$app->request->post('Menu');
            $menu->setAttributes($data,false);
            $result=MenuService::instance()->update($menu);
            if(is_null($result))
                return self::error();
            return self::success('操作成功');
        }
        $groupList=UserService::instance()->getUserGroupList(new Page(1,500));
        return $this->render('update',['menu'=>$menu,'groupList'=>$groupList]);
    }



}