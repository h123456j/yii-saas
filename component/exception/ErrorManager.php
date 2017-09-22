<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/22
 * Time: 10:31
 */

namespace app\component\exception;


use yii\base\Component;

class ErrorManager extends Component
{

    private $errorCode = null;
    private $errorMessage = null;


    public function init()
    {

    }

    public function getCode($destroy = false)
    {
        $errorCode = $this->errorCode;
        if ($destroy) {
            $this->errorCode = null;
            $this->errorMessage = null;
        }
        return $errorCode;
    }

    public function getMessage()
    {
        return $this->errorMessage;
    }

    public function hasError()
    {
        return $this->errorCode != null;
    }


    public function push($error, $message = null)
    {
        if (is_object($error) && $error instanceof \Exception) {
            $this->errorCode = $error->getCode();
            $this->errorMessage = $error->getMessage();
        } else {
            $this->errorCode = $error;
            $this->errorMessage = $message;
        }

        return true;
    }

}