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
 */
class CommonController extends BaseController
{

    public $layout=false;
    /**
     * @api-name 文件上传
     * @api-url common/upload
     * @api-method POST
     * @api-param array $files 文件流参数，支持批量上传
     * @api-response {
     * }
     */
    public function actionUpload()
    {
        if(\Yii::$app->request->getIsPost()){
            $data=CommonService::instance()->upload();
            if(is_null($data))
                \Yii::$app->response->error();
            \Yii::$app->response->success($data);
        }
        return $this->render("/upload.php");
    }

}