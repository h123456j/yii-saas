<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 17:58
 */

namespace api\controllers;


use app\component\controller\BaseController;

/**
 * Class RedeemBuildingController
 * @package api\controllers
 * @controller-name  赎楼模块
 */
class RedeemBuildingController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[]);
    }

    /**
     * @api-name 赎楼预约
     * @api-method POST
     * @api-url redeem-building/appointment
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param string $content 预约内容(json格式：）
     * @api-response {
     *     "data":"1",(1-成功 0-失败)
     * }
     *
     */
    public function actionAppointment()
    {

    }

}