<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 13:18
 */

namespace app\component\filter;

use common\error\Error;
use yii\base\ActionFilter;
use yii\helpers\VarDumper;

defined('YII_REQUEST_START_TIME')  or define('YII_REQUEST_START+TIME',time());

class Signature extends ActionFilter
{

    public function beforeAction()
    {
        return $this->filterSign();
    }

    /**
     * 签名校验
     * @return bool
     */
    protected function filterSign()
    {
        \Yii::beginProfile('FILTER-SIGN-'.YII_REQUEST_START_TIME);
        $host=\Yii::$app->request->getHostInfo();
        $method=\Yii::$app->request->getIsPost()?'post':'get';
        $uri = ltrim(\Yii::$app->urlManager->createUrl(\Yii::$app->request->getPathInfo()), '/');
        $params=array_merge($_GET,$_POST);
        if(!isset($params['sign'])){
            \Yii::error('is no sign');
            \Yii::endProfile('FILTER-SIGN-'.YII_REQUEST_START_TIME);
            \Yii::$app->response->error(Error::COMMON_SIGN_ERROR,'缺少签名');
        }
        $secretKey=\Yii::$app->params['secretKey'];
        $dateTime=strtotime(date('Y-m-d H:i',time()));
        $sign=$params['sign'];
        unset($params['sign']);
        ksort($params);
        $signString=$host.'/'.$uri.'&'.$method;
        foreach($params as $key=>$item){
            $signString.='&'.$key.'='.$item;
        }
        $temp=self::createSign($signString,$secretKey,$dateTime);

        if($temp !=$sign){
            \Yii::error('sign is error,signString:['.$signString.'],dataTime:'.$dateTime.',sign:'.$temp);
            \Yii::endProfile('FILTER-SIGN-'.YII_REQUEST_START_TIME);
            \Yii::$app->response->error(Error::COMMON_SIGN_ERROR,'签名错误');
        }
        \Yii::endProfile('FILTER-SIGN-'.YII_REQUEST_START_TIME);
        return true;
    }

    /**
     * 创建签名
     * @param $data
     * @param $secret
     * @param null $dataTime
     * @return string
     */
    private static function createSign($data,$secret,$dataTime=null)
    {
        $data=strtolower($data);
        $key=$data.'&'.$secret;
        if(!is_null($dataTime))
            $key.='&'.$dataTime;
        return md5($key);
    }

}