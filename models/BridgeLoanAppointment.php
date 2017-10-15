<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:37
 */

namespace app\models;


class BridgeLoanAppointment extends \app\models\table\BridgeLoanAppointment
{

    const STATUS_FOR_NOT_AUDIT=1;//审核未通过

    public function scenarioFields()
    {
        return [

        ];
    }

}