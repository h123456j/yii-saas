<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:34
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class BridgeLoanAppointment extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%bridge_loan_appointment}}';
    }

}