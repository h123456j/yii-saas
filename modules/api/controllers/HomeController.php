<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/11
 * Time: 21:37
 */

namespace api\controllers;


use app\component\controller\BaseController;
use app\component\filter\ApiSessionFilter;
use app\component\model\Page;
use app\services\HomePageService;
use common\error\Error;
use yii\helpers\VarDumper;

/**
 * Class HomeController
 * @package api\controllers
 * @controller-name 主页模块
 * @controller-rank 13
 */
class HomeController extends BaseController
{

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'session' => [
                'class' => ApiSessionFilter::className(),
                'only' => ['appointment']
            ]
        ]);
    }

    /**
     * @api-name 月排表
     * @api-method GET
     * @api-url home/month-table
     * @api-param string $date 开始日期（选填，格式：YY-m-d 默认当天）
     * @api-param int $size 取数条数（默认30）
     * @api-response {
     *    "data":[
     *          {
     *       "date": "2017-10-20",日期
     *       "freezeMoney": "0.00",冻结金额
     *       "usableMoney": "1000.00",可用金额
     *       "useMoney": "0.00",已用金额
     *         },
     *       ...
     *     ]
     * }
     */
    public function actionMonthTable()
    {
        $date = \Yii::$app->request->get('date');
        $size = \Yii::$app->request->get('size');
        if (empty($size))
            $size = 30;
        $pager = new Page(1, $size);
        $result = HomePageService::instance()->getMonthTable($date, $pager);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }

    /**
     * @api-name 预约
     * @api-method POST
     * @api-url home/appointment
     * @api-param int $cate 类别（1-过桥预约 2-赎楼预约 3-物业预约 4-其他预约 默认为1）
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param string $content 预约内容（josn格式：<br/>过桥预约:{"name":"借款主体名称","contacts":"联系人","contactsTel":"联系人电话","money":"资金缺口","appointmentDate":"预约用款日（yy-m-d）","useDays":"使用天数（天）","recentlyDate":"最早用款日（yy-）","lastDate":"最迟用款日(yy-m-d)","property":"性质（0-非合同期内;1-合同期内）"}）
     * <br/><br/>赎楼预约:{"contacts":"联系人","contactsTel":"联系人电话","profession":"职业","buildingName":"楼盘名称","bank":"贷款银行","money":"资金缺口","useDays":"预计使用天数（天）","remark":"其他说明","files":"附件地址[多个附件用半角符分割]"}
     * <br/><br/>物业预约:{"cate":"类别[类别0-未知 1-厂房 2-土地 3-自建房 4-商品房 5-商铺],"cateProperty":"类别性质[0-未知 1-商业 2-商住 3-住宅 4-划拨]","owner":"业主名称","contacts":"联系人","contactsTel":"联系人电话","landArea":"土地面积","buildingArea":"建筑面积","property":"建筑性质[0-未知 1-一般物业【没有贷款】 2-贷款物业【正常贷款】 3-已逾期 4-已查封 5-已判决 6-已在淘宝拍卖]","files":"附件地址[多个附件用半角符分割]"}
     * <br/><br/>其他预约:{"contacts":"联系人","contactsTel":"联系人电话","cate":"业务类别[0-未知 1-国土抵押加急 2-国土注册加急 3-国土过户加急 4-公证加急 5-做流水 6-做主体 7-跨行过桥 8-抵押 9-淘宝拍卖]","remark":"其他说明","files":"附件地址[多个附件用半角符分割]"}）
     * @api-response {
     *      "data":"1"(0-失败 1-成功)
     * }
     */
    public function actionAppointment()
    {
        $request = \Yii::$app->request;
        $cate = $request->post('cate');
        if (empty($cate))
            $cate = 1;
        $content = $request->post('content');
        $content = json_decode($content, true);
        if (empty($content))
            \Yii::$app->response->error(Error::COMMON_PARAM_INVALID, '参数不合法');
        $result = HomePageService::instance()->appointment($cate, $content);
        if (is_null($result))
            \Yii::$app->response->error();
        \Yii::$app->response->success($result);
    }


}