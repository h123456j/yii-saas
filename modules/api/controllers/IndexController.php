<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/13
 * Time: 15:18
 */

namespace api\controllers;


use app\component\controller\BaseController;

/**
 * Class IndexController
 * @package api\controllers
 *
 *  @controller-name 主页
 */
class IndexController extends BaseController
{

    /**
     * @api-name 首页模块
     * @api-method GET
     * @api-url /api/index
     * @api-param string $id 记录id
     * @api-param string $uid 用户id
     * @api-response {
     *       "id":"1",
     *       "name":"记录1",
     *    }
     */
    public function actionIndex()
    {
        echo  "接口测试";
    }

    /**
     * @api-name 获取分页
     * @api-method POST
     * @api-url index/get-page
     * @api-param int page  分页id
     * @api-param int pageSize  每页数量
     * @api-response {
     *     "curent":"1",
     *     "total":"10",
     *     "count":"100",
     *     "size":"10"
     *}
     * @api-exception {
     *     "10000":"系统错误"
     * }
     */
    public function actionGetPage()
    {

    }

}