<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/9/17
 * Time: 11:11
 */

namespace app\component\filter;


use backend\models\Menu;
use yii\base\ActionFilter;

class AuthFilter extends ActionFilter
{

   public $callback;

    /**
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        $class=$action->controller;
        $method=$action->actionMethod;
        $ref=new \ReflectionMethod($class,$method);
        $comment=$this->getComments($ref->getDocComment());
        if(isset($comment['auth_route'])){
            $route=$comment['auth_route'];
            $menu=Menu::findOne(['hide'=>0,'status'=>1,'url'=>$route]);
            if(empty($menu)){
                call_user_func($this->callback,false);
                return false;
            }
            if($menu->group_id==0)
                return true;
            $userAuth=\Yii::$app->user->identity->group_id;
            $temp=explode(',',$menu->group_id);
            if(in_array($userAuth,$temp))
                return true;
            call_user_func($this->callback,false);
            return false;
        }
        return true;
    }

    /**
     * 获取方法的注释内容
     * @param $comments
     * @return array
     */
    public function getComments($comments)
    {
        $note = [];
        if (preg_match_all('/@([a-zA-Z0-9\_\-]+)+\s+(([a-zA-Z0-9\_\-\/\?\=\&]+)|(\{+\S+\}))/', $comments, $matches)) {
            foreach ($matches[0] as $key => $value) {
                $value = preg_replace("/@([a-zA-Z0-9\_\-]+)+/", "", $value);
                if ($matches[1][$key] == "param") {
                    $note[$matches[1][$key]][] = trim($value);
                } else {
                    $note[$matches[1][$key]] = trim($value);
                }
            }
        }
        return $note;
    }

}