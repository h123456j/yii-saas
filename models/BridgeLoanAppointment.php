<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 16:37
 */

namespace app\models;


use app\component\model\Page;

class BridgeLoanAppointment extends \app\models\table\BridgeLoanAppointment
{

    const STATUS_FOR_NOT_AUDIT = 1;//审核未通过
    public static $statusDesc = [1 => '未审核', 2 => '已审核'];
    public static $propertyDesc = ['非合同期内', '合同期内'];

    public $nickname;

    public function scenarioFields()
    {
        return [
            'list' => [
                'id',
                'title' => 'borrower',
                'date' => 'create_time',
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                }
            ],
            'info' => [
                'id',
                'borrower',
                'contacts',
                'contactsTel' => 'contacts_tel',
                'money',
                'appointmentDate' => 'appointment_date',
                'useDays' => 'usage_days',
                'recentlyDate' => 'recently_date',
                'lastDate' => 'last_date',
                'property',
                'propertyDesc' => function () {
                    return self::$propertyDesc[$this->property];
                },
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                },
                'auditTime' => 'audit_time',
                'remark',
                'createTime' => 'create_time',
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

    public static function getList(Page $pager, $condition = [])
    {
        $query = self::find()
            ->select('bl.*,ui.nickname')
            ->from(self::tableName() . ' bl')
            ->leftJoin(self::getFullName('user_info ui'), 'bl.uid=ui.uid')
            ->where(['bl.is_deleted' => 0])
            ->orderBy(['bl.create_time' => SORT_DESC, 'bl.update_time' => SORT_DESC]);
        $pager->setCount($query->count());
        $query->offset($pager->getOffset())
            ->limit($pager->getLimit());
        return $query->all();
    }

}