<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 17:45
 */

namespace app\models;


use app\component\model\Page;

class RedeemBuildingAppointment extends \app\models\table\RedeemBuildingAppointment
{

    const STATUS_FOR_NOT_AUDIT = 1;//审核未通过
    public static $statusDesc = [1 => '未审核', 2 => '已审核'];

    public function scenarioFields()
    {
        return [
            'list' => [
                'id',
                'title' => 'building_name',
                'date' => 'create_time',
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                }
            ],
            'info' => [
                'id',
                'contacts',
                'contactsTel' => 'contacts_tel',
                'profession',
                'buildingName' => 'building_name',
                'bank',
                'money',
                'useDays' => 'usage_days',
                'remark',
                'files' => function () {
                    return empty($this->files) ? [] : explode(',', $this->files);
                },
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                },
                'createTime' => 'create_time',
                'auditTime' => 'audit_time',
                'updateTime' => 'update_time'
            ]
        ];
    }

    public static function getAppointmentList(Page $pager, $uid = null, $scenario = null)
    {
        $query = self::find()
            ->select('*')
            ->where(['is_deleted' => 0])
            ->orderBy(['create_time' => SORT_DESC, 'update_time' => SORT_DESC]);

        if (!is_null($uid))
            $query->andWhere(['uid' => $uid]);

        $pager->setCount($query->count());
        $data = $query->offset($pager->getOffset())
            ->limit($pager->getLimit())->all();

        if (empty($data) || is_null($scenario))
            return $data;

        foreach ($data as $item) {
            $item->setScenario($scenario);
        }
        return $data;
    }

}