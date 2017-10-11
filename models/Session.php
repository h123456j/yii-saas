<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 17:14
 */

namespace app\models;


use yii\helpers\VarDumper;

class Session extends \app\models\table\Session
{

    private static $duration=30*24*60*60;

    /**
     * 获取用户session
     * @param $uid
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getSession($uid)
    {
        return self::find()->select('uid,sid,valid_time,update_time')->where(['uid'=>$uid])->one();
    }

    /**
     * 删除用户session
     * @param $uid
     * @return int
     */
    public static function delSession($uid)
    {
        return self::deleteAll(['uid'=>$uid]);
    }

    /***
     * 更新用户session
     * @param $uid
     * @param $sid
     * @param null $duration
     * @return bool
     */
    public static function updateSession($uid,$sid,$duration=null)
    {
        $session=self::find()->select('uid,sid,valid_time,update_time')->where(['uid'=>$uid])->one();
        if(empty($session))
            $session=new self;
        if(is_null($duration))
            $duration=self::$duration;
        $session->uid=$uid;
        $session->sid=$sid;
        $session->valid_time=time()+$duration;
        $session->update_time=date('Y-m-d H:i:s');
        return $session->save();
    }

}