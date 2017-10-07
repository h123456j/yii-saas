<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 22:22
 */

namespace api\controllers;


use app\component\controller\BaseController;
use app\services\api\BridgeLoanService;

/**
 * Class BridgeLoanController
 * @package api\controllers
 * @controller-name 过桥贷款
 */
class BridgeLoanController extends BaseController
{
    /**
     * @api-name 月排表
     * @api-url bridge-loan/month-table
     * @api-method GET
     * @api-param string $date 开始时间日期[2017-10-08]（可选,默认当天）
     * @api-param int $size 取数条数（可选，默认30）
     * @api-response {
     *   "data": [
     *            {
     *         "date": "2017-10-07", 日期
     *         "totalMoney": 1000,总金额（万元）
     *         "freezeMoney": 200,冻结金额（万元）
     *         "usableMoney": 500,可用金额（万元）
     *         "useMoney": 300,已用金额（万元）
     *           },
     *          ...
     *      ],
     * }
     */
    public function actionMonthTable()
    {
        $date = \Yii::$app->request->get('date');
        $size = \Yii::$app->request->get('size');
        if (empty($date))
            $date = date('Y-m-d');
        if (empty($size))
            $size = 30;
        $data = BridgeLoanService::instance()->getMonthTable($date, $size);
        if (is_null($data))
            \Yii::$app->response->error();
        \Yii::$app->response->success($data);
    }

    /**
     * @api-name  过桥贷款预约
     * @api-url bridge-loan/appointment
     * @api-method　POST
     * @api-param string $date 预约日期[2017-10-08]
     * @api-param string $content 预约内容（json格式：）
     * @api-response {
     *    "data":"1" (1-成功 0-失败)
     * }
     */
    public function actionAppointment()
    {

    }

}