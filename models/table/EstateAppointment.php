<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:36
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class EstateAppointment extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%estate_appointment}}';
    }

}