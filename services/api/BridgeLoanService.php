<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 22:32
 */

namespace app\services\api;


use app\models\BridgeLoanMonthTable;
use app\services\base\BaseService;
use common\error\Error;
use yii\base\Exception;
use yii\helpers\VarDumper;

class BridgeLoanService extends BaseService
{

    public function getMonthTable($date,$size)
    {
        $data=BridgeLoanMonthTable::getMonthTable($date,$size);
        if(is_null($data))
            throw new Exception("数据库故障",Error::COMMON_DB);
        $data=[
            [
                'date'=>'2017-10-07',
                'totalMoney'=>1000,
                'freezeMoney'=>200,
                'usableMoney'=>500,
                'useMoney'=>300
            ],
            [
                'date'=>'2017-10-08',
                'totalMoney'=>1000,
                'freezeMoney'=>400,
                'usableMoney'=>500,
                'useMoney'=>100
            ]
        ];
        return $data;
    }

}