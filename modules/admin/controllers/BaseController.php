<?php

namespace backend\controllers;

use app\component\filter\AuthFilter;
use backend\models\Config;
use common\error\Error;
use Yii;
use app\common\core\Controller;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;

/**
 * ---------------------------------------
 * 后台父类控制器
 * 后台所有控制器都继承自该类
 * @author longfei phphome@qq.com
 * ---------------------------------------
 */
class BaseController extends Controller
{

    const DEFAULT_PAGE = 1;//默认页码
    const DEFAULT_PAGE_SIZE = 10;//默认每页数量

    public $enableCsrfValidation = false;

    /**
     * ---------------------------------------
     * 行为控制
     * ---------------------------------------
     */
    public function behaviors()
    {
        return [
            'session' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],
//            'auth' => [
//                'class' => AuthFilter::className(),
//                'callback' =>function($data){
//                    return $this->redirect(Url::toRoute(['public/no-auth']));
//                }
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * ---------------------------------------
     * 后台构造函数
     * ---------------------------------------
     */
    public function init()
    {

    }

    public function setPageTitle($title)
    {
        $this->getView()->title = $title;
    }

    public static function systemError()
    {
        return Yii::$app->response->redirect('/admin/public/50x');
    }


    public static function pageNotFind()
    {
        return Yii::$app->response->redirect('/admin/public/404');
    }

    /**
     * ------------------------------------------------
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @return void
     * ------------------------------------------------
     */
    protected function ajaxReturn($data)
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        return json_encode($data);
    }

    /**
     * 成功返回
     * @param $message
     * @return string
     */
    protected static function success($message='操作成功')
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        return json_encode(['status' => 1, 'message' => $message]);
    }

    /**
     * 错误返回
     * @param null $code
     * @param null $message
     * @return string
     */
    protected static function error($code = null, $message = null)
    {
        // 返回JSON数据格式到客户端 包含状态信息
        header('Content-Type:application/json; charset=utf-8');
        if ($code == null && $message == null) {
            $code = Yii::$app->errorManager->getCode();
            $message = Yii::$app->errorManager->getMessage();
        }
        return json_encode([
            'status' => 0,
            'code' => empty($code) ? Error::COMMON_PARAM_INVALID : $code,
            'message' => empty($message) ? Error::COMMON_PARAM_INVALID : $message,
        ]);
    }

}
