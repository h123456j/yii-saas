<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 23:09
 */

namespace app\models;


class BridgeLoanMonthTable extends \app\models\table\BridgeLoanMonthTable
{

    /**
     * 获取过桥贷款月排表数据
     * @param $date
     * @param $size
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMonthTable($date,$size)
    {
        return self::find()
            ->select('*')
            ->where('date >=:date',[':date'=>$date])
            ->limit($size)
            ->all();
    }

}