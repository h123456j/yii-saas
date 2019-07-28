<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/8
 * Time: 15:43
 */

namespace app\models\table;



use common\core\BaseActiveRecord;

class FieldDetailEntity extends BaseActiveRecord
{

    const FIELD_TYPE_FOR_TABLE_REALITY = '真实字段';
    const FIELD_TYPE_FOR_TABLE_MAP = '映射字段';
    const FIELD_TYPE_FOR_TABLE_JOIN = '关联字段';

    const DATA_TYPE_FOR_STRING = '字符串';
    const DATA_TYPE_FOR_FILE_OBJECT = '单附件';
    const DATA_FOR_FOR_FILE_ARRAY = '多附件';

    const SCENARIO_CODE_FOR_DEFAULT = 'default';
    const SCENARIO_CODE_FOR_SYNC_LIST = 'sync_list';

    public static function tableName()
    {
        return 'd_field_detail';
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'module_id',
            'module_name'
        ]);
    }

    public function scenarioFields()
    {
        return [
            self::SCENARIO_CODE_FOR_SYNC_LIST => [
                'module_id',
                'module_name',
                'table_name',
                'name_chn',
                'name_eng',
                'widget',
                'length' => function () {
                    $json = empty($this->extra) ? [] : json_decode($this->extra, true);
                    if (isset($json['rule']['maxLength'])) {
                        return $json['rule']['maxLength'];
                    }
                    return null;
                },
                'file_module'
            ]
        ];
    }

    /**
     * 判断是否为文件类型
     * @param $dataType
     * @return bool
     */
    public static function dataTypeIsFile($dataType)
    {
        return in_array($dataType, [
            self::DATA_TYPE_FOR_FILE_OBJECT,
            self::DATA_FOR_FOR_FILE_ARRAY
        ]);
    }

    /**
     * 是否为表真实字段属性
     * @param $fieldType
     * @return bool
     */
    public static function fieldTypeIsReality($fieldType)
    {
        return ($fieldType === self::FIELD_TYPE_FOR_ENTITY) || ($fieldType == self::FIELD_TYPE_FOR_TABLE_REALITY);
    }

    /**
     * 是否为表虚拟映射字段
     * example：供应商主表d_supplier营业期限【虚拟字段business_erm对应表真实字段work_start_date，work_end_date，no_fixed_term】
     * @param $fieldType
     * @return bool
     */
    public static function fieldTypeIsMap($fieldType)
    {
        return $fieldType === self::FIELD_TYPE_FOR_VIRTUAL || $fieldType == self::FIELD_TYPE_FOR_TABLE_MAP;
    }

    /**
     * 关联表属性字段
     * example:供应商服务公司service_company字段对应关联列表d_supplier_company
     * @param $fieldType
     * @return bool
     */
    public static function fieldTypeIsJoin($fieldType)
    {
        return $fieldType === self::FIELD_TYPE_FOR_JOIN || $fieldType == self::FIELD_TYPE_FOR_TABLE_JOIN;
    }


}