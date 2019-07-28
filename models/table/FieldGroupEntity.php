<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/8
 * Time: 15:45
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class FieldGroupEntity extends BaseActiveRecord
{

    const TAB_TYPE_FOR_SUPPLIER_ARCHIVE = 'archive';
    const TAB_TYPE_FOR_PROJECT_BID = 'bid';//项目招标
    const TAB_TYPE_FOR_STRATEGY_BID = 'strategy_bid';//战略招标
    const TAB_TYPE_FOR_SUPPLIER_BID = 'bid';
    const TAB_TYPE_FOR_PROTOCOL = 'protocol';

    const GROUP_TYPE_FOR_OBJECT = 'object';//对象分组
    const GROUP_TYPE_FOR_LIST = 'list';//列表分组

    const SCENARIO_CODE_FOR_LIST = 'list';

    public static function tableName()
    {
        return 'd_field_group';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'group_id',
            'group_type',
            'tab_name',
            'tab_code'
        ]);
    }

    public function scenarioFields()
    {
        return [
            self::SCENARIO_CODE_FOR_LIST => [
                'group_id' => 'group_id'
            ]
        ];
    }

}