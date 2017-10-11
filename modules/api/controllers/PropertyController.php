<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 18:02
 */

namespace api\controllers;


use app\component\controller\BaseController;

/**
 * Class PropertyController
 * @package api\controllers
 * @controller-name 物业模块
 */
class PropertyController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[

        ]);
    }

    /**
     * @api-name 物业预约
     * @api-method POST
     * @api-url property/appointment
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param string $content 预约内容（json格式：）
     * @api-response{
     * }
     */
    public function actionAppointment()
    {

    }

}