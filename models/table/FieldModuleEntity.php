<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/11
 * Time: 14:08
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class FieldModuleEntity extends BaseActiveRecord
{

    const MODULE_TYPE_FOR_OBJECT = 'object';
    const MODULE_TYPE_FOR_LIST = 'list';
    const MODULE_TYPE_FOR_FILE_LIST = 'file_list';

    const MODULE_TYPE_FOR_SUPPLIER_OBJECT = 'supplier_object';
    const MODULE_TYPE_FOR_BID_OBJECT = 'bid_object';
    const MODULE_TYPE_FOR_PROTOCOL_OBJECT = 'protocol_object';

    const USER_INDEX_FOR_0 = 0;
    const USER_INDEX_FOR_1 = 1;

    public static function tableName()
    {
        return 'd_field_module';
    }

}