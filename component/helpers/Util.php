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
     * @param bool|false $toLong
     * @return mixed
     */
    public static function getIp($toLong = false)
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
        return $toLong ? ip2long($ip) : $ip;
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
    public static function generatePassword($password, $salt)
    {
        return md5($password . '-' . $salt);
    }

    public static function getUrl($uri, $params = [])
    {
        if (empty($uri))
            return null;
        if (!empty($params))
            $uri = strpos($uri, '?') === false ? $uri . '?' . http_build_query($params) : $uri . '&' . http_build_query($params);
        if (strpos($uri, 'http') !== false)
            return $uri;
        return \yii\helpers\Url::toRoute($uri);
    }

    public static function trim(&$data)
    {
        if (!is_array($data))
            return null;
        foreach ($data as &$item) {
            trim($item);
        }
    }

    public static function noAuth()
    {
        $url=self::getUrl('public/no-auth');
        \Yii::$app->response->redirect($url);
    }

    public static function systemError()
    {
        $url=self::getUrl('public/50x');
        \Yii::$app->response->redirect($url);
    }

}