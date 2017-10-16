<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/10/10
 * Time: 10:21
 */

namespace app\models;


class UserInfo extends \app\models\table\UserInfo
{

    public static $userType = [1, 2, 3, 4];
    public $sexDesc = ['保密', '先生', '女士'];
    public $typeDesc = [1 => '客户经理', 2 => '内部人员', '3' => '地产中介', 4 => '其他'];

    public function scenarioFields()
    {
        return [
            'info' => [
                'uid',
                'nickname',
                'headPhoto' => 'head_photo',
                'tel',
                'sex',
                'sexDesc' => function () {
                    return $this->sexDesc[$this->sex];
                },
                'type',
                'typeDesc' => function () {
                    return $this->typeDesc[$this->type];
                }
            ]
        ];
    }

    public static function checkNickname($uid, $nickname)
    {
        $nickname = trim($nickname);
        return self::find()->where('nickname =:nickname and uid <> :uid', [':nickname' => $nickname, ':uid' => $uid])->count();
    }


}