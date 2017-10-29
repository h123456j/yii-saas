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
use app\services\AppointmentService;
use app\services\HomePageService;
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
        if (!is_null($date)){
            $schedule = $appointmentService->getScheduleInfoByDate($date);
            $schedule->setScenario(AppointmentSchedule::SCENARIO_FOR_UPDATE);
        }else{
            $schedule->setScenario(AppointmentSchedule::SCENARIO_FOR_CREATE);
        }
        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('AppointmentSchedule');
            Util::trim($data);
            if(isset($data['startDate'])){
                $result=HomePageService::instance()->addSchedule($data);
            }else{
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

    public function actionBridgeLoadList($page=self::DEFAULT_PAGE,$pageSize=self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('过桥贷款列表');
        $pager=new Page($page,$pageSize);
        $data=AppointmentService::instance()->getList($pager);
        $pages=new Pagination(['totalCount'=>$pager->getCount(),'pageSize'=>$pageSize]);
        return $this->render('bridge-list',['data'=>$data,'pages'=>$pages]);
    }

    public function actionEstateList($page=self::DEFAULT_PAGE,$pageSize=self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('物业预约列表');
        $pager=new Page($page,$pageSize);
    } 

    public function actionRedeemBuildingList()
    {
        $this->setPageTitle('赎楼预约列表');
    }

    public function actionOtherList()
    {
        $this->setPageTitle('其他预约列表');
    }

}