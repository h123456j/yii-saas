<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/14
 * Time: 14:17
 */

namespace app\component\session;
use yii\helpers\VarDumper;

/**
 * api全局session容器
 * Class SessionContainer
 * @package app\component\session
 */
class SessionContainer
{

    private static $uid;
    private static $sid;

    private function __construct()
    {
        //私有化构造
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public static function init($session)
    {
        self::$uid = isset($session['uid']) ? floatval($session['uid']) : null;
        self::$sid = isset($session['sid']) ? $session['sid'] : null;
    }

    public static function getUid()
    {
        return self::$uid;
    }

    public static function getSid()
    {
        return self::$sid;
    }

}