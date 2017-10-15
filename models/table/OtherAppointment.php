<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 18:13
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class OtherAppointment extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%other_appointment}}';
    }
}