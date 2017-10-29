<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/6
 * Time: 23:09
 */

namespace app\models;


use app\component\model\Page;
use yii\helpers\VarDumper;

class AppointmentSchedule extends \app\models\table\AppointmentSchedule
{

    const DEFAULT_MONEY = 1000;
    const SCENARIO_FOR_UPDATE='update';
    const SCENARIO_FOR_CREATE='create';

    public $startDate;
    public $endDate;

    public function rules()
    {
        return [
            [['startDate'],'required','message'=>'开始时间必填','on'=>[self::SCENARIO_FOR_CREATE]],
            [['total_money'],'required','message'=>'该字段不能为空'],
            [['total_money'],'number','message'=>'金额不合法']
        ];
    }

    public function scenarioFields()
    {
        return [
            'list' => [
                'date',
                'freezeMoney' => 'freeze_money',
                'usableMoney' => 'usable_money',
                'useMoney' => 'use_money'
            ]
        ];
    }

    /**
     * 获取过桥贷款月排表数据
     * @param $date
     * @param Page $pager
     * @param null $scenario
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getMonthTable($date, Page $pager, $scenario = null)
    {
        $query = self::find()
            ->select('*')
            ->where('date >=:date', [':date' => $date])
            ->orderBy(['date' => SORT_ASC]);

        $pager->setCount($query->count());

        $data = $query->offset($pager->getOffset())
            ->limit($pager->getLimit())
            ->all();

        if (empty($data) || is_null($scenario))
            return $data;

        foreach ($data as $item) {
            $item->setScenario($scenario);
        }
        return $data;
    }

    public static function batchInsert($fields, $values)
    {
        return self::getDb()->createCommand()
            ->batchInsert(self::tableName(), $fields, $values)->execute();
    }

    public static function getList(Page $pager, $condition = [])
    {
        $query = self::find()
            ->select('*')
            ->where(['status' => 1]);
        if (isset($condition['orderBy'])) {
            $query->orderBy($condition['orderBy']);
        } else {
            $query->orderBy(['date' => SORT_DESC]);
        }
        $pager->setCount($query->count());

        return $query->offset($pager->getOffset())
            ->limit($pager->getLimit())
            ->all();
    }

}