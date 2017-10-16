<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/16
 * Time: 16:16
 */

namespace app\component\helpers;


class Util
{
    /**
     * 生成uid
     * @return mixed
     */
    public static function generateUid()
    {
        return microtime(true) * 10000;
    }

    /**
     * 获取客户端ip
     * @return string
     */
    public static function getIp()
    {
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } else if (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = "unknown";
        }
        return $ip;
    }

    /**
     * 生成盐值
     * @return string
     */
    public static function generateSalt()
    {
        return md5(microtime(true));
    }

    /**
     * 生成密码
     * @param $password
     * @param $salt
     * @return string
     */
    public static function generatePassword($password,$salt)
    {
        return md5($password.'-'.$salt);
    }

}