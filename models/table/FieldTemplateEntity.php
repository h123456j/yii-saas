<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/7/12
 * Time: 14:43
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class FieldTemplateEntity extends BaseActiveRecord
{

    const TEMPLATE_CODE_FOR_EMPTY_TYPE = 'empty_type';//空类模板

    public static function tableName()
    {
        return 'd_field_template';
    }

}