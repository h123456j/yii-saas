<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 13:59
 */

namespace app\services;


use app\component\session\SessionContainer;
use app\models\AppointmentSchedule;
use app\models\BridgeLoanAppointment;
use app\models\EstateAppointment;
use app\models\OtherAppointment;
use app\models\RedeemBuildingAppointment;
use app\services\base\BaseService;
use common\error\Error;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class HomePageService extends BaseService
{

    const APPOINTMENT_TYPE_FOR_BRIDGE_LOAN = 1;//过桥预约
    const APPOINTMENT_TYPE_FOR_REDEEM_BUILDING = 2;//赎楼预约
    const APPOINTMENT_TYPE_FOR_ESTATE = 3;//物业预约
    const APPOINTMENT_TYPE_FOR_OTHER = 4;//其他预约

    private static $fields = ['date', 'total_money', 'usable_money', 'update_time'];

    /**
     * 过桥月排表
     * @param $date
     * @param $pager
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getMonthTable($date, $pager)
    {
        if (empty($date))
            $date = date('Y-m-d');
        $dateList = self::getDateList($date, $pager->getLimit());
        $appointmentSchedule = new AppointmentSchedule();
        $data = $appointmentSchedule::getMonthTable($date, $pager, 'list');
        if (empty($data)) {
            $values = [];
            foreach ($dateList as $item) {
                $values[] = self::createValues($item);
            }
            $appointmentSchedule::batchInsert(self::$fields, $values);
            return $appointmentSchedule::getMonthTable($date, $pager, 'list');
        }

        $temp = ArrayHelper::getColumn($data, 'date');
        $diff = array_diff($dateList, $temp);
        if (!empty($diff)) {
            $values = [];
            foreach ($diff as $item) {
                $values[] = self::createValues($item);
            }
            $appointmentSchedule::batchInsert(self::$fields, $values);
            return $appointmentSchedule::getMonthTable($date, $pager, 'list');
        }
        return $data;
    }

    protected static function getDateList($date, $size = 30)
    {
        $date = strtotime($date);
        $dateList = [];
        for ($i = 0; $i < $size; $i++) {
            $dateList[] = date('Y-m-d', strtotime('+' . $i . 'days', $date));
        }
        return $dateList;
    }

    private static function createValues($date)
    {
        return [
            'date' => $date,
            'total_money' => AppointmentSchedule::DEFAULT_MONEY,
            'usable_money' => AppointmentSchedule::DEFAULT_MONEY,
            'update_time' => date('Y-m-d H:i:s')
        ];
    }


    public function appointment($cate, $content)
    {
        switch ($cate) {
            case self::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN:
                return $this->bridgeLoanAppointment($content);
                break;
            case self::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING:
                return $this->redeemBuildingAppointment($content);
                break;
            case self::APPOINTMENT_TYPE_FOR_ESTATE:
                return $this->estateAppointment($content);
                break;
            case self::APPOINTMENT_TYPE_FOR_OTHER:
                return $this->otherAppointment($content);
                break;
            default:
                throw new \yii\base\Exception('不存在的预约类型', Error::COMMON_PARAM_INVALID);
                break;
        }
    }

    /**
     * 过桥预约
     * @param $content
     * @return bool
     * @throws Exception
     */
    private function bridgeLoanAppointment($content)
    {
        $bridgeLoanAppointment = new BridgeLoanAppointment();
        $bridgeLoanAppointment->uid = SessionContainer::getUid();
        $bridgeLoanAppointment->borrower = $content['name'];
        $bridgeLoanAppointment->contacts = $content['contacts'];
        $bridgeLoanAppointment->contacts_tel = $content['contactsTel'];
        $bridgeLoanAppointment->money = $content['money'];
        $bridgeLoanAppointment->appointment_date = $content['appointmentDate'];
        $bridgeLoanAppointment->usage_days = $content['useDays'];
        $bridgeLoanAppointment->recently_date = $content['recentlyDate'];
        $bridgeLoanAppointment->last_date = $content['lastDate'];
        $bridgeLoanAppointment->property = $content['property'];
        $bridgeLoanAppointment->status = $bridgeLoanAppointment::STATUS_FOR_NOT_AUDIT;
        $bridgeLoanAppointment->audit_time = $bridgeLoanAppointment->create_time = $bridgeLoanAppointment->update_time = date('Y-m-d H:i:s');
        $transaction = $bridgeLoanAppointment->getDb()->beginTransaction();
        try {
            $result = $bridgeLoanAppointment->save();
            $money = $bridgeLoanAppointment->money;
            $sDate = $bridgeLoanAppointment->recently_date;
            $eDate = $bridgeLoanAppointment->last_date;
            AppointmentSchedule::updateAll([
                'freeze_money' => new Expression('freeze_money+' . $money),
                'usable_money' => new Expression('usable_money-' . $money)
            ], 'date between :sDate and :eDate', [':sDate' => $sDate, ':eDate' => $eDate]);
            $transaction->commit();
            return $result;
        } catch (\yii\base\Exception $e) {
            $transaction->rollBack();
            throw new Exception();
        }
    }

    /**
     * 赎楼预约
     * @param $content
     * @return bool
     */
    private function redeemBuildingAppointment($content)
    {
        $redeemBuildingAppointment = new RedeemBuildingAppointment();
        $redeemBuildingAppointment->uid = SessionContainer::getUid();
        $redeemBuildingAppointment->contacts = $content['contacts'];
        $redeemBuildingAppointment->contacts_tel = $content['contactsTel'];
        $redeemBuildingAppointment->profession = $content['profession'];
        $redeemBuildingAppointment->building_name = $content['buildingName'];
        $redeemBuildingAppointment->bank = $content['bank'];
        $redeemBuildingAppointment->money = $content['money'];
        $redeemBuildingAppointment->usage_days = $content['useDays'];
        $redeemBuildingAppointment->remark = $content['remark'];
        $redeemBuildingAppointment->files = $content['files'];
        $redeemBuildingAppointment->audit_time = $redeemBuildingAppointment->create_time = $redeemBuildingAppointment->update_time = date('Y-m-d H:i:s');
        return $redeemBuildingAppointment->save();
    }

    /**
     * 物业预约
     * @param $content
     * @return bool
     */
    private function estateAppointment($content)
    {
        $estateAppoitment = new EstateAppointment();
        $estateAppoitment->uid = SessionContainer::getUid();
        $estateAppoitment->cate = $content['cate'];
        $estateAppoitment->cate_property = $content['cateProperty'];
        $estateAppoitment->owner = $content['owner'];
        $estateAppoitment->contacts = $content['contacts'];
        $estateAppoitment->contacts_tel = $content['contactsTel'];
        $estateAppoitment->land_area = $content['landArea'];
        $estateAppoitment->building_area = $content['buildingArea'];
        $estateAppoitment->property = $content['property'];
        $estateAppoitment->files = $content['files'];
        $estateAppoitment->audit_time = $estateAppoitment->create_time = $estateAppoitment->update_time = date('Y-m-d H:i:s');
        return $estateAppoitment->save();
    }

    /**
     * 其他预约
     * @param $content
     * @return bool
     */
    private function otherAppointment($content)
    {
        $otherAppointment = new OtherAppointment();
        $otherAppointment->uid = SessionContainer::getUid();
        $otherAppointment->contacts = $content['contacts'];
        $otherAppointment->contacts_tel = $content['contactsTel'];
        $otherAppointment->cate = $content['cate'];
        $otherAppointment->remark = $content['remark'];
        $otherAppointment->files = $content['files'];
        $otherAppointment->audit_time = $otherAppointment->create_time = $otherAppointment->update_time = date('Y-m-d H:i:s');
        return $otherAppointment->save();
    }

}