<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/17
 * Time: 10:05
 */

namespace app\services;


use app\models\AppointmentSchedule;
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
    const IS_DELETE = 1;
    public static $statusDesc = [
        '1' => '未审核',
        '2' => '审核通过'
    ];

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
                $info = [];
                break;
        }
        if (empty($info))
            throw  new Exception('记录查询失败', Error::COMMON_DB);
        $info->setScenario($scenario);
        return $info;
    }

    public function update($object, $type)
    {
        $object->audit_time = $object->update_time = date('Y-m-d H:i:s');
        return $object->save();
    }


    public function getList($pager, $type = HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN)
    {
        switch ($type) {
            case HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN:
                return BridgeLoanAppointment::getList($pager);
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_ESTATE:
                return EstateAppointment::getList($pager);
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING:
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_OTHER:
                break;
            default:
                return [];
                break;
        }
    }

    public function appointmentDel($id, $type = HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN)
    {
        switch ($type) {
            case HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN:
                $data = BridgeLoanAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case  HomePageService::APPOINTMENT_TYPE_FOR_ESTATE:
                $data = EstateAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case  HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING:
                $data = RedeemBuildingAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_OTHER:
                $data = OtherAppointment::findOne(['id' => $id, 'is_deleted' => self::IS_NOT_DELETE]);
                break;
            default:
                $data = [];
                break;
        }
        if (empty($data))
            return false;
        $data->is_deleted = self::IS_DELETE;
        return $data->save();
    }

    public function getScheduleList($pager)
    {
        return AppointmentSchedule::getList($pager);
    }

    public function getScheduleInfoByDate($date)
    {
        return AppointmentSchedule::findOne(['date' => $date]);
    }

    public function scheduleUpdate(AppointmentSchedule $schedule)
    {
        $money = $schedule->freeze_money + $schedule->use_money;
        $schedule->usable_money = $schedule->total_money - $money;
        if ($schedule->usable_money < 0)
            throw new Exception('填写的总金额数不能小于' . $money . '万', Error::COMMON_PARAM_INVALID);
        return $schedule->save();
    }

}