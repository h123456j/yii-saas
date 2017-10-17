<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/17
 * Time: 10:05
 */

namespace app\services;


use app\models\BridgeLoanAppointment;
use app\models\EstateAppointment;
use app\models\OtherAppointment;
use app\models\RedeemBuildingAppointment;
use app\services\base\BaseService;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class AppointmentService extends BaseService
{

    const IS_NOT_DELETE = 0;

    public function getInfo($id, $type, $scenario = 'info')
    {
        switch ($type) {
            case HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN:
                $info = BridgeLoanAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case  HomePageService::APPOINTMENT_TYPE_FOR_ESTATE:
                $info = EstateAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case  HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING:
                $info = RedeemBuildingAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_OTHER:
                $info = OtherAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            default:
                $info=[];
                break;
        }
        if (empty($info))
            throw  new Exception('记录查询失败', Error::COMMON_DB);
        $info->setScenario($scenario);
        return $info;
    }

}