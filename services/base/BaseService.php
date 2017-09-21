<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 11:43
 */

namespace app\services\base;



use app\component\service\Interceptor;

class BaseService
{

    private static $_instance=[];

    /**
     * 私有化构造方法
     * BaseService constructor.
     */
    private function __construct()
    {

    }

    /**
     * 私有化克隆方法
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * 获取实例
     * @return mixed
     */
    public static function instance()
    {
        $class=get_called_class();
        if(!isset(self::$_instance[$class]))
            self::$_instance[$class]=new Interceptor(new  $class());
        return self::$_instance[$class];
    }



}