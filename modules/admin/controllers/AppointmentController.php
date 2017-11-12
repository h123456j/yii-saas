<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/22
 * Time: 21:35
 */

namespace backend\controllers;


use app\component\helpers\Util;
use app\component\model\Page;
use app\models\AppointmentSchedule;
use app\models\BridgeLoanAppointment;
use app\models\EstateAppointment;
use app\models\OtherAppointment;
use app\models\RedeemBuildingAppointment;
use app\services\AppointmentService;
use app\services\HomePageService;
use common\error\Error;
use yii\data\Pagination;
use yii\helpers\VarDumper;

class AppointmentController extends BaseController
{

    public function actionIndex()
    {
        $this->setPageTitle('预约模块');
        return $this->render('/common');
    }

    public function actionMonthTable($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('月排表');
        $pager = new Page($page, $pageSize);
        $result = AppointmentService::instance()->getScheduleList($pager);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('month-table', ['data' => $result, 'pages' => $pages]);
    }

    public function actionScheduleUpdate($date = null)
    {
        $this->layout = '/admin/simple';
        $schedule = new AppointmentSchedule();
        $appointmentService = AppointmentService::instance();
        if (!is_null($date)) {
            $schedule = $appointmentService->getScheduleInfoByDate($date);
            $schedule->setScenario(AppointmentSchedule::SCENARIO_FOR_UPDATE);
        } else {
            $schedule->setScenario(AppointmentSchedule::SCENARIO_FOR_CREATE);
        }
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('AppointmentSchedule');
            Util::trim($data);
            if (isset($data['startDate'])) {
                $result = HomePageService::instance()->addSchedule($data);
            } else {
                $schedule->setAttributes($data, false);
                $schedule->setScenario('default');
                $result = $appointmentService->scheduleUpdate($schedule);
            }
            if (is_null($result))
                return self::error();
            return self::success();
        }

        return $this->render('schedule-update', ['data' => $schedule]);
    }

    public function actionBridgeLoanList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('过桥贷款列表');
        $pager = new Page($page, $pageSize);
        $data = AppointmentService::instance()->getList($pager);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('bridge-list', ['data' => $data, 'pages' => $pages]);
    }

    public function actionBridgeLoadUpdate($id = null,$look=false)
    {
        $this->layout = '/admin/simple';
        if (is_null($id)) {
            $bridgeLoanInfo = new BridgeLoanAppointment();
        } else {
            $bridgeLoanInfo = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN);
        }

        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('BridgeLoanAppointment');
            $bridgeLoanInfo->setAttributes($data, false);
            $bridgeLoanInfo->setScenario('default');
            $result = AppointmentService::instance()->update($bridgeLoanInfo, HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN);
            if (is_null($result))
                return self::error();
            return self::success();
        }

        if (is_null($bridgeLoanInfo))
            return Util::systemError();

        return $this->render('bridge-loan-update', ['data' => $bridgeLoanInfo,'look'=>$look]);

    }

    public function actionEstateList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('物业预约列表');
        $pager = new Page($page, $pageSize);
        $data = AppointmentService::instance()->getList($pager, HomePageService::APPOINTMENT_TYPE_FOR_ESTATE);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('estate-list', ['data' => $data, 'pages' => $pages]);
    }


    public function actionEstateUpdate($id = null, $look = false)
    {
        $this->layout = '/admin/simple';
        if (is_null($id)) {
            $estate = new EstateAppointment();
        } else {
            $estate = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_ESTATE);
        }
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('EstateAppointment');
            $estate->setAttributes($data, false);
            $estate->setScenario('default');
            $result = AppointmentService::instance()->update($estate, HomePageService::APPOINTMENT_TYPE_FOR_ESTATE);
            if (is_null($result))
                return self::error();
            return self::success();
        }
        if (is_null($estate))
            return Util::systemError();

        return $this->render('estate-update', ['data' => $estate, 'look' => $look]);
    }

    public function actionRedeemBuildingList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('赎楼预约列表');
        $pager = new Page($page, $pageSize);
        $data = AppointmentService::instance()->getList($pager, HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('redeem-building-list', ['data' => $data, 'pages' => $pages]);
    }

    public function actionRedeemBuildingUpdate($id = null, $look = false)
    {
        $this->layout = '/admin/simple';
        if (is_null($id)) {
            $redeemBuilding = new RedeemBuildingAppointment();
        } else {
            $redeemBuilding = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING);
        }
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('RedeemBuildingAppointment');
            $redeemBuilding->setAttributes($data, false);
            $redeemBuilding->setScenario('default');
            $result = AppointmentService::instance()->update($redeemBuilding, HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING);
            if (is_null($result))
                return self::error();
            return self::success();
        }
        if (is_null($redeemBuilding))
            return Util::systemError();
        return $this->render('redeem-building-update', ['data' => $redeemBuilding, 'look' => $look]);
    }

    public function actionOtherList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('其他预约列表');
        $pager = new Page($page, $pageSize);
        $data = AppointmentService::instance()->getList($pager, HomePageService::APPOINTMENT_TYPE_FOR_OTHER);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('other-list', ['data' => $data, 'pages' => $pages]);
    }

    public function actionOtherUpdate($id = null, $look = false)
    {
        $this->layout = '/admin/simple';
        if (is_null($id)) {
            $other = new OtherAppointment();
        } else {
            $other = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_OTHER);
        }
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('OtherAppointment');
            Util::trim($data);
            $other->setAttributes($data, false);
            $other->setScenario('default');
            $result = AppointmentService::instance()->update($other, HomePageService::APPOINTMENT_TYPE_FOR_OTHER);
            if (is_null($result))
                return self::error();
            return self::success();
        }
        if (is_null($other))
            return Util::systemError();

        return $this->render('other-update', ['data' => $other, 'look' => $look]);
    }

    public function actionDel()
    {
        $id = \Yii::$app->request->post('id');
        $type = \Yii::$app->request->post('type');
        $result = AppointmentService::instance()->appointmentDel($id, $type);
        if (empty($result))
            return self::error(Error::COMMON_DB, '删除失败');
        return self::success('删除成功');
    }

}