<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:35
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class RedeemBuildingAppointment extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%redeem_building_appointment}}';
    }

}