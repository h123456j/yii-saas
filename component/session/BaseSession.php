<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 16:38
 */

namespace app\component\session;


use yii\web\Session;

class BaseSession extends Session
{
    /**
     * 获取用户session
     * @param string $uid
     * @return array|null|\yii\db\ActiveRecord
     */
    public function readSession($uid)
    {
        return \app\models\Session::getSession($uid);
    }

    /**
     * session写入
     * @param string $uid
     * @param string $data
     * @param null $duration
     * @return bool
     */
    public function writeSession($uid,$data,$duration=null)
    {
       return \app\models\Session::updateSession($uid,$data,$duration);
    }

    /**
     * 删除用户session
     * @param string $uid
     * @return int
     */
    public function destroySession($uid)
    {
        return \app\models\Session::delSession($uid);
    }

}