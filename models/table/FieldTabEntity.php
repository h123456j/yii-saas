<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/8
 * Time: 15:44
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class FieldTabEntity extends BaseActiveRecord
{

    const TAB_TYPE_FOR_SUPPLIER_ARCHIVE = 'archive';//企业档案tab
    const TAB_TYPE_FOR_PARAM_SETTING = 'setting';//参数设置tab
    const TAB_TYPE_FOR_SUPPLIER_BID = 'bid';//招标过程
    const TAB_TYPE_FOR_STRATEGY_BID = 'strategy_bid';//战略招标
    const TAB_TYPE_FOR_BID_SOLUTION = 'bid_solution';//招标过程
    const TAB_TYPE_FOR_ASSESS_GRADE = 'assess_grade';//评估定级
    const TAB_TYPE_FOR_BID_APPLY = 'bid_apply';//招标申请

    const TAB_CODE_FOR_MATERIALS = 'materials';//材料类招标申请
    const TAB_CODE_FOR_CONSTRUCTION = 'construct';//施工类招标申请

    public static function tableName()
    {
        return 'd_field_tab';
    }

}