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
     * @param string $id
     * @return array|null|\yii\db\ActiveRecord
     */
    public function readSession($id)
    {
        return \app\models\Session::getSession($id);
    }

    /**
     * session写入
     * @param string $id
     * @param string $data
     * @param null $duration
     * @return bool
     */
    public function writeSession($id,$data,$duration=null)
    {
       return \app\models\Session::updateSession($id,$data,$duration);
    }

    /**
     * 删除用户session
     * @param string $id
     * @return int
     */
    public function destroySession($id)
    {
        return \app\models\Session::delSession($id);
    }

}