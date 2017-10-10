<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/10/10
 * Time: 10:20
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class UserInfo extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%user_info}}';
    }

}