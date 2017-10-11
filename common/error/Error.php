<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 15:34
 */

namespace common\error;


class Error
{

    const COMMON_DB = '100000';
    const COMMON_UNKNOWN = '100001';
    const COMMON_ILLEGALITY_CLIENT = '100002';//非法客户端
    const COMMON_SIGN_ERROR = '100003';//签名错误

    const FILE_FOR_EMPTY='200000';//空文件
    const FILE_FOR_ILLEGAL_TYPE='200001';//非法文件类型
    

}