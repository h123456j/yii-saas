<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 18:02
 */

namespace app\models;


use app\component\model\Page;

class EstateAppointment extends \app\models\table\EstateAppointment
{

    const STATUS_FOR_NOT_AUDIT = 1;//审核未通过
    public static $statusDesc = [1 => '未审核', 2 => '通过',3=>'不通过'];
    public static $cateDesc = ['未知', '厂房', '土地', '自建房', '商品房', '商铺'];
    public static $catePropertyDesc = ['未知', '商业', '商住', '住宅', '划拨'];
    public static $propertyDesc = [0 => '未知', 1 => '一般物业【没有贷款】', 2 => '贷款物业【正常贷款】', 3 => '已逾期', 4 => '已查封', 5 => '已判决', 6 => '已在淘宝拍卖'];

    //附加字段
    public $nickname;

    public function scenarioFields()
    {
        return [
            'list' => [
                'id',
                'title' => 'owner',
                'date' => 'create_time',
                'status',
                'statusDesc' => function () {
                    return self::$statusDesc[$this->status];
                }
            ],
            'info' => [
                'id',
                'cate',
                'cateDesc' => function () {
                    return self::$cateDesc[$this->cate];
                },
                'cateProperty' => 'cate_property',
                'catePropertyDesc' => function () {
                    return self::$catePropertyDesc[$this->cate_property];
                },
                'owner',
                'contacts',
                'contactsTel' => 'contacts_tel',
                'landArea' => 'land_area',
                'buildingArea' => 'building_area',
                'property',
                'propertyDesc' => function () {
                    return self::$propertyDesc[$this->property];
                },
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

    public static function getList(Page $pager, $condition = [])
    {
        $query = self::find()
            ->select('ea.*,ui.nickname')
            ->from(self::tableName() . ' ea')
            ->leftJoin(self::getFullName('user_info ui'), 'ea.uid=ui.uid')
            ->where(['ea.is_deleted' => 0])
            ->orderBy(['ea.create_time' => SORT_DESC, 'ea.update_time' => SORT_DESC]);
        $pager->setCount($query->count());
        $query->offset($pager->getOffset())
            ->limit($pager->getLimit());
        return $query->all();
    }

}