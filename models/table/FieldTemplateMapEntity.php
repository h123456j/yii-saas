<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/7/12
 * Time: 14:44
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class FieldTemplateMapEntity extends BaseActiveRecord
{

    public static function tableName()
    {
        return 'd_field_template_map';
    }

}