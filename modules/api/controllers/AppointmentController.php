<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/17
 * Time: 10:00
 */

namespace api\controllers;

use app\component\controller\BaseController;
use app\component\filter\ApiSessionFilter;
use app\services\AppointmentService;
use app\services\HomePageService;

/**
 * Class AppointmentController
 * @package api\controllers
 * @controller-name 预约模块
 * @controller-rank 10
 */
class AppointmentController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'session' => ApiSessionFilter::className()
        ]);
    }

    /**
     * @api-name 过桥预约详情
     * @api-method POST
     * @api-url appointment/bridge-loan-info
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $id 记录id
     * @api-response{
     *    "data": {
     *       "id": 8,记录id
     *       "borrower": "测试借款主体",借款主体
     *       "contacts": "测试联系人",联系人
     *       "contactsTel": "15311583010",联系电话
     *       "money": "200",借款金额
     *       "appointmentDate": "2017-10-25",预约用款日期
     *       "useDays": 10,使用天数
     *       "recentlyDate": "2017-10-20",最近使用日期
     *       "lastDate": "2017-10-30",最后使用日期
     *       "property": 1,合同属性（0-非合同期内 1-合同期内）
     *       "propertyDesc": "合同期内",属性描述
     *       "status": 1,状态（1-未审核 2-已审核）
     *       "statusDesc": "未审核",状态描述
     *       "auditTime": "2017-10-15 17:28:32",审核时间
     *       "remark": null,备注
     *       "createTime": "2017-10-15 17:28:32",创建时间
     *       "updateTime": "2017-10-15 17:28:32",更新时间
     * },
     * }
     */
    public function actionBridgeLoanInfo()
    {
        $id = \Yii::$app->request->post('id');
        $result = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 物业预约详情
     * @api-method POST
     * @api-url appointment/estate-info
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $id 记录id
     * @api-response{
     *     "data": {
     *        "id": 1,记录id
     *        "cate": 1,类别（0-未知 1-厂房 2-土地 3-自建房 4-商品房 5-商铺）
     *        "cateDesc": "厂房",类别描述
     *        "cateProperty": 1,类别属性（0-未知 1-商业 2-商住 3-住宅 4-划拨）
     *        "catePropertyDesc": "商业",类别属性描述
     *        "owner": "测试业主",所有者
     *        "contacts": "测试联系人",联系人
     *        "contactsTel": "18166044582",联系人电话
     *        "landArea": "250",占地面积（平方米）
     *        "buildingArea": "200",建筑面积（平方米）
     *        "property": 1,物业属性（（0-未知 1-一般物业【没有贷款】 2-贷款物业【正常贷款】 3-已逾期 4-已查封 5-已判决 6-已在淘宝拍卖））
     *        "propertyDesc": "一般物业【没有贷款】",物业属性描述
     *        "remark": null,备注
     *        "files": [],附件列表
     *        "status": 2,（1-未审核 2-已审核）
     *        "statusDesc": "已审核",
     *        "createTime": "2017-10-15 18:07:47",创建时间
     *        "auditTime": "2017-10-15 18:07:47",审核时间
     *        "updateTime": "2017-10-15 18:07:47",更新时间
     *     }
     * }
     */
    public function actionEstateInfo()
    {
        $id = \Yii::$app->request->post('id');
        $result = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_ESTATE);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 赎楼预约详情
     * @api-method POST
     * @api-url appointment/redeem-building-info
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param string $id 记录id
     * @api-response {
     *     "data": {
     *        "id": 1,记录id
     *        "contacts": "测试联系人",联系人
     *        "contactsTel": "18166044582",联系人电话
     *        "profession": "测试职业",置业
     *        "buildingName": "测试楼盘",建筑名称
     *        "bank": "中国银行",贷款银行
     *        "money": "200",自己缺口
     *        "useDays": 20,使用天数
     *        "remark": "其他说明",备注
     *        "files": [],附件列表
     *        "status": 2,状态（1-未审核 2-已审核）
     *        "statusDesc": "已审核",状态描述
     *        "createTime": "2017-10-15 17:56:31",创建时间
     *        "auditTime": "2017-10-15 17:56:31",审核时间
     *        "updateTime": "2017-10-15 17:56:31",更新时间
     *       }
     * }
     */
    public function actionRedeemBuildingInfo()
    {
        $id = \Yii::$app->request->post('id');
        $result = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name  其他预约详情
     * @api-method POST
     * @api-url appointment/other-info
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param int $id 记录id
     * @api-response{
     *     "data": {
     *        "id": 1,记录id
     *        "contacts": "测试联系人",联系人
     *        "contactsTel": "18166044582",联系电话
     *        "cate": 1,分类（0-未知 1-国土抵押加急 2-国土注册加急 3-国土过户加急 4-公证加急 5-做流水 6-做主体 7-跨行过桥 8-抵押 9-淘宝拍卖）
     *        "cateDesc": "国土抵押加急",分类描述
     *        "remark": "其他说明",备注
     *        "status": 2,状态（1-未审核 2-已审核）
     *        "statusDesc": "已审核",
     *        "createTime": "0000-00-00 00:00:00",创建时间
     *        "auditTime": "2017-10-15 18:18:42",审核时间
     *        "updateTime": "2017-10-15 18:18:42",更新时间
     *       }
     * }
     */
    public function actionOtherInfo()
    {
        $id = \Yii::$app->request->post('id');
        $id = 1;
        $result = AppointmentService::instance()->getInfo($id, HomePageService::APPOINTMENT_TYPE_FOR_OTHER);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }


}