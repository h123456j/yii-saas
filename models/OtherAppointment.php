<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 18:13
 */

namespace app\models;


use app\component\model\Page;

class OtherAppointment extends \app\models\table\OtherAppointment
{

    const STATUS_FOR_NOT_AUDIT = 1;//审核未通过
    public static $statusDesc = [1 => '未审核', 2 => '已审核'];
    public static $cateDesc = [
        0 => '未知',
        1 => '国土抵押加急',
        2 => '国土注册加急',
        3 => '国土过户加急',
        4 => '公证加急',
        5 => '做流水',
        6 => '做主体',
        7 => '跨行过桥',
        8 => '抵押',
        9 => '淘宝拍卖'
    ];

    public function scenarioFields()
    {
        return [
            'list' => [
                'id',
                'title' => function () {
                    return $this->contacts . '预约';
                },
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
                'cate',
                'cateDesc' => function () {
                    return self::$cateDesc[$this->cate];
                },
                'remark',
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                },
                'createTime'=>'create_time',
                'auditTime'=>'audit_time',
                'updateTime'=>'update_time'
            ]
        ];
    }

    public static function getAppointmentList(Page $pager, $uid = null, $scenario = null)
    {
        $query = self::find()
            ->select('*')
            ->where(['is_deleted' => 0])
            ->orderBy(['create_time' => SORT_DESC, 'update_time' => SORT_DESC])
            ->offset($pager->getOffset())
            ->limit($pager->getLimit());

        if (!is_null($uid))
            $query->andWhere(['uid' => $uid]);

        $pager->setCount($query->count());
        $data = $query->all();
        if (empty($data) || is_null($scenario))
            return $data;

        foreach ($data as $item) {
            $item->setScenario($scenario);
        }
        return $data;
    }

}