<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/10/10
 * Time: 11:41
 */

namespace api\controllers;


use app\component\controller\BaseController;
use app\services\CommonService;
use yii\helpers\VarDumper;

/**
 * Class CommonController
 * @package api\controllers
 * @controller-name 公共模块
 * @controller-rank 15
 */
class CommonController extends BaseController
{

    public $layout = false;

    /**
     * @api-name 附件上传
     * @api-url common/upload
     * @api-method POST
     * @api-param array $files 文件流参数名，支持批量上传
     * @api-response {
     *    "data": [
     *         {
     *      "name": "190048q7ttjmrbwz4vbfj1.jpg",文件名称
     *      "path": "/uploads/2017-10-11/e359e2a739730a3492a93b51e00f40b5.jpg",文件地址
     *        },
     *    ...
     *      ]
     * }
     */
    public function actionUpload()
    {
        $data = CommonService::instance()->upload();
        if (is_null($data))
            \Yii::$app->response->error();
        \Yii::$app->response->success($data);
    }

}