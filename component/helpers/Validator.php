<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:00
 */

namespace app\component\helpers;


class Validator
{
    /**
     * 邮件校验
     * @param $email
     * @return int
     */
    public static function isEmail($email)
    {
        return preg_match(
            '/^([a-zA-Z0-9]*[-_]?[a-zA-Z0-9]+)*@([a-zA-Z0-9]*[-_]?[a-zA-Z0-9]+)+[\\.][A-Za-z]{2,5}([\\.][A-Za-z]{2,3})?$/',
            $email
        );
    }

    /**
     * 有效手机号校验
     * @param $phone
     * @return int
     */
    public static function isMobile($phone)
    {
        return preg_match('/^(13[0-9]|15[012356789]|17[0135678]|18[0-9]|14[579])[0-9]{8}$/', $phone);
    }

}