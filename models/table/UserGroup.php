<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 16:48
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class UserGroup extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%admin_user_group}}';
    }

}