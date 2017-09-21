<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 15:14
 */

namespace app\component\service;


use app\services\base\BaseService;
use common\error\Error;
use yii\base\UnknownMethodException;
use yii\db\Exception;
use yii\helpers\Json;
use yii\helpers\VarDumper;

/**
 * service调用拦截器
 * Class Interceptor
 * @package app\component\service
 */
class Interceptor
{

    private $service;
    private $serviceName;


    public function __construct(BaseService $service)
    {
        $this->service = $service;
        $this->serviceName = get_class($service);
    }

    /**
     * 返回当前service对象
     * @return mixed
     */
    public function noInterceptor()
    {
        return $this->service;
    }

    public function __call($name, $arguments)
    {
        \Yii::beginProfile('SERVICE-' . $this->serviceName . '-' . $name . '-' . YII_REQUEST_START_TIME);
        if (is_null($this->service))
            throw  new \Exception('this service of interceptor is null');

        $funcName = sprintf("service: %s::%s(%s)", $this->serviceName, $name, Json::encode($arguments));

        try {
            if (method_exists($this->service, $name)) {
                $data = call_user_func_array([$this->service, $name], $arguments);
            } else {
                throw  new  UnknownMethodException('calling unknown method:' . $this->serviceName . "::$name");
            }
            $this->info(sprintf("\r\n%s \r\nresult:%s\r\n", $funcName, Json::encode($data)));
        } catch (Exception $e) {
            $this->error(sprintf("\r\n%s \r\ndbException:{code:%s,message:%s,dbMessage:%s}", $funcName, $e->getCode(), $e->getMessage(), VarDumper::dumpAsString($e->errorInfo)));
            \Yii::$app->errorHandler->push(Error::COMMON_DB, '数据库故障');
            $data = null;
        } catch (\yii\base\Exception $e) {
            $this->error("\r\n%s \r\nException:{code:%s,message:%s}", $funcName, $e->getCode(), $e->getMessage());
            $this->error(sprintf("\r\n%s \r\nException: { code: %s, trace's message: %s }", $funcName, $e->getCode(), $e->getTraceAsString()));
            \Yii::$app->errorManager->push($e);
            $data = null;
        } catch (\Exception $e) {
            $this->error(sprintf("\r\n%s \r\nException: { code: %s, message: %s }", $funcName, $e->getCode(),
                $e->getMessage()));

            $this->error(sprintf("\r\n%s \r\nException: { code: %s, trace's message: %s }", $funcName, $e->getCode(),
                $e->getTraceAsString()));

            \Yii::$app->errorManager->push(Error::COMMON_UNKNOWN, '未知错误');

            $data = null;
        }
        \Yii::beginProfile('SERVICE-' . $this->serviceName . '-' . $name . '-' . YII_REQUEST_START_TIME);
        return $data;
    }

    protected function error($msg)
    {
        \Yii::error($msg, 'service.' . $this->serviceName);
    }

    protected function info($msg)
    {
        \Yii::info($msg, 'service.' . $this->serviceName);
    }

    protected function trace($msg)
    {
        \Yii::trace($msg, 'service.' . $this->serviceName);
    }

    protected function warn($msg)
    {
        \Yii::warning($msg, 'service.' . $this->serviceName);
    }

}