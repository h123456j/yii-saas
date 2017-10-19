<?php

namespace backend\controllers;

use app\component\filter\AuthFilter;
use backend\models\Config;
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

    const DEFAULT_PAGE=1;//默认页码
    const DEFAULT_PAGE_SIZE=15;//默认每页数量

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
            'auth' => [
                'class' => AuthFilter::className(),
                'callback' =>function($data){
                    return $this->redirect(Url::toRoute(['public/no-auth']));
                }
            ]
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

}
