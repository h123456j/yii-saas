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
//        VarDumper::dump($result,10,true);die;
        return $this->render('list',['data'=>$result]);
    }

    public function actionUpdate($id=null,$pid=0)
    {
        $this->layout='/admin/simple';
        $menu=new Menu();
        if(!is_null($id))
            $menu=MenuService::instance()->getMenuById($id);

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