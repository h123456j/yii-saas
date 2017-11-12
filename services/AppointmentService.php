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
use app\models\Message;
use app\models\OtherAppointment;
use app\models\RedeemBuildingAppointment;
use app\services\base\BaseService;
use common\error\Error;
use yii\base\Exception;
use yii\db\Expression;
use yii\helpers\VarDumper;

class AppointmentService extends BaseService
{

    const IS_NOT_DELETE = 0;
    const IS_DELETE = 1;
    public static $statusDesc = [
        '1' => '未审核',
        '2' => '通过',
        '3' => '不通过'
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
        $now = date('Y-m-d H:i:s');
        $status = $object->status;
        $oldStatus = $object->oldAttributes['status'];
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            if ($status != $oldStatus) {
                $object->audit_time = $now;
                if ($status == BridgeLoanAppointment::STATUS_FOR_NOT_AUDIT)
                    throw new Exception('该预约已经审核,不支持变更为未审核状态', Error::COMMON_PARAM_INVALID);

                if ($type == HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN) {
                    $money = $object->money;
                    $startDate = $object->recently_date;
                    $endDate = $object->last_date;
                    if ($oldStatus == BridgeLoanAppointment::STATUS_FOR_NOT_AUDIT && $status == BridgeLoanAppointment::STATUS_FOR_AUDIT_OK) {//未审核状态变更为审核通过
                        AppointmentSchedule::updateAll([
                            'freeze_money' => new  Expression('freeze_money-' . $money),
                            'use_money' => new  Expression('use_money+' . $money),
                        ], 'date between :startDate and :endDate', [':startDate' => $startDate, ':endDate' => $endDate]);
                    } elseif ($oldStatus == BridgeLoanAppointment::STATUS_FOR_NOT_AUDIT && $status == BridgeLoanAppointment::STATUS_FOR_AUDIT_FAIL) {//未审核状态变更为审核失败
                        AppointmentSchedule::updateAll([
                            'freeze_money' => new  Expression('freeze_money-' . $money),
                            'usable_money' => new  Expression('usable_money+' . $money),
                        ], 'date between :startDate and :endDate', [':startDate' => $startDate, ':endDate' => $endDate]);
                    } elseif ($oldStatus == BridgeLoanAppointment::STATUS_FOR_AUDIT_OK && $status == BridgeLoanAppointment::STATUS_FOR_AUDIT_FAIL) {//审核通过变更为审核不通过
                        AppointmentSchedule::updateAll([
                            'usable_money' => new  Expression('usable_money+' . $money),
                            'use_money' => new  Expression('use_money-' . $money),
                        ], 'date between :startDate and :endDate', [':startDate' => $startDate, ':endDate' => $endDate]);
                    } elseif ($oldStatus == BridgeLoanAppointment::STATUS_FOR_AUDIT_FAIL && $status == BridgeLoanAppointment::STATUS_FOR_AUDIT_OK) {//审核失败变更为审核通过
                        AppointmentSchedule::updateAll([
                            'usable_money' => new  Expression('usable_money-' . $money),
                            'use_money' => new  Expression('use_money+' . $money),
                        ], 'date between :startDate and :endDate', [':startDate' => $startDate, ':endDate' => $endDate]);
                    }
                }
                //通知消息处理
                $message=new Message();
                $message->uid=$object->uid;
                $message->title='预约审核';
                $message->type=$message::TYPE_FOR_APPOINTMENT;
                $message->content='您的'.HomePageService::
                $message->create_time=$message->update_time=date('Y-m-d H:i:s');
            }
            $object->update_time = date('Y-m-d H:i:s');
            $result = $object->save();
            $transaction->commit();
            return $result;
        } catch (Exception $e) {
            $transaction->rollBack();
            \Yii::error("服务出错:".$e->getMessage());
            throw  new Exception('数据库故障',Error::COMMON_DB);
        }
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
                return RedeemBuildingAppointment::getList($pager);
                break;
            case HomePageService::APPOINTMENT_TYPE_FOR_OTHER:
                return OtherAppointment::getList($pager);
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