<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 17:13
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class Session extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%user_session}}';
    }

}