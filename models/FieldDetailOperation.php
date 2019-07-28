<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/8
 * Time: 15:46
 */

namespace app\models;


use app\models\table\FieldDetailEntity;

class FieldDetailOperation extends FieldDetailEntity
{

    /**
     * 获取表单属性列表
     * @param array $groupIds
     * @param array $moduleIds
     * @param array $fieldIds
     * @param null $selectFields
     * @param bool $asArray
     * @param null $indexBy
     * @param null $scenario
     * @return array
     */
    public function getFieldDetailList($groupIds = [], $moduleIds = [], $fieldIds = [], $selectFields = null, $asArray = true, $indexBy = null, $scenario = null)
    {
        is_null($selectFields) && $selectFields = 'dfd.*,dfm.module_name,dfm.group_id,dfm.module_code,dfm.module_type,dfm.module_service,dfm.use_index module_use_index,dfm.extra module_extra,dfm.widget module_widget,dfm.required module_required,dfm.check_rule module_check_rule,dfm.not_compare_fields';
        is_array($selectFields) && $selectFields = implode(',', $selectFields);
        $data = FieldDetailEntity::find()
            ->select($selectFields)
            ->from(FieldDetailEntity::tableName() . ' dfd')
            ->leftJoin('d_field_module dfm', 'dfd.module_id=dfm.id')
            ->where(['dfd.is_deleted' => self::IS_DELETED_0, 'dfd.is_show' => 1, 'dfm.is_deleted' => self::IS_DELETED_0, 'dfm.is_show' => 1])
            ->andFilterWhere(['in', 'dfm.group_id', $groupIds])
            ->andFilterWhere(['in', 'dfm.id', $moduleIds])
            ->andFilterWhere(['in', 'dfd.id', $fieldIds])
            ->orderBy(['dfm.sort' => SORT_ASC, 'dfd.sort' => SORT_ASC])
            ->asArray($asArray)
            ->indexBy($indexBy)
            ->all();
        if (is_array($data) && !is_null($scenario)) {
            foreach ($data as &$item) {
                $item->setScenario($scenario);
            }
        }
        return $data;
    }






}