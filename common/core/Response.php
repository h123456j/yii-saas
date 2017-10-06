<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 13:30
 */

namespace common\core;


use yii\helpers\VarDumper;

class Response extends \yii\web\Response
{

    private $session='';

    private $_error;

    public $errorManager;

    public $formatter=[];

    public function init()
    {
        parent::init();
        $this->_error=\Yii::$app->get($this->errorManager);
    }

    public function setSession($sid)
    {
        $this->session=$sid;
    }

    /**
     * 错误返回
     * @param null $code
     * @param null $message
     */
    public function error($code=null,$message=null)
    {
        $this->format=self::FORMAT_JSON;

        if($code==null && $message==null){
            $code=$this->_error->getCode();
            $message=$this->_error->getMessage();
        }

        $result=[
            'code'=>$code,
            'message'=>$message,
            'sid'=>$this->session,
            'nonce'=>time()
        ];

        $requestParams=$_REQUEST;

        $requestResult=[
            'api'=>\Yii::$app->request->getAbsoluteUrl(),
            'request'=>$requestParams,
            'result'=>$result
        ];

        \Yii::error(json_encode($requestResult,JSON_UNESCAPED_UNICODE));

        $allback=\Yii::$app->request->get('callback');

        if(!empty($allback))
            $this->format=self::FORMAT_JSONP;

        $this->data=[
            'ret'=>false,
            'result'=>$result
        ];

        \Yii::$app->end();

    }

    /**
     * 成功返回
     * @param string $data
     */
    public function success($data='')
    {
        $this->format=self::FORMAT_JSON;
        $result=[];

        $result['data']=$data;
        $result['sid']=$this->session;
        $result['nonce']=time();

        $callback=\Yii::$app->request->get('callback');

        if(!empty($callback)){
            $this->format=self::FORMAT_JSONP;
            $this->data=[
                'ret'=>true,
                'result'=>$data,
                'callback'=>$callback
            ];
        }else{
            $this->data=[
                'ret'=>true,
                'result'=>$result
            ];
        }

        \Yii::info('response success:'.VarDumper::dumpAsString($this->data));
        \Yii::$app->end();
    }


}