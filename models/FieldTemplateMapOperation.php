<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/7/13
 * Time: 11:26
 */

namespace app\models;

use app\models\table\FieldTemplateMapEntity;

class FieldTemplateMapOperation extends FieldTemplateMapEntity
{

    /**
     * 根据模板获取获取模板属性映射列表
     * @param $templateCode
     * @return array
     */
    public function getTemplateMapList($templateCode)
    {
        is_string($templateCode) && $templateCode = explode(',', $templateCode);
        return FieldTemplateMapEntity::find()
            ->select('ftm.field_id,ftm.module_required,ftm.field_required,ftm.tab_id,ftm.group_id,ftm.module_id,ftm.extra template_extra,ft.name template_name,ft.code template_code')
            ->from(FieldTemplateMapEntity::tableName() . ' ftm')
            ->leftJoin(FieldTemplateEntity::tableName() . ' ft', 'ftm.template_id=ft.id')
            ->where(['ftm.is_deleted' => self::IS_DELETED_0, 'ft.is_deleted' => self::IS_DELETED_0])
            ->andWhere(['in', 'ft.code', $templateCode])
            ->createCommand()
            ->queryAll();
    }

    /**
     * 获取模板映射字段列表
     * @param $templateCodeList
     * @return array
     */
    public function getTemplateMapListWithModule($templateCodeList)
    {
        is_string($templateCodeList) && $templateCodeList = explode(',', $templateCodeList);
        return FieldTemplateMapEntity::find()
            ->select('fmd.module_code,fd.name_eng,fields,field_type')
            ->from(FieldTemplateMapEntity::tableName() . ' ftm')
            ->leftJoin(FieldTemplateEntity::tableName() . ' ft', 'ftm.template_id=ft.id')
            ->leftJoin(FieldModuleEntity::tableName() . ' fmd', 'ftm.module_id=fmd.id')
            ->leftJoin(FieldDetailEntity::tableName() . ' fd', 'ftm.field_id=fd.id')
            ->where(['ftm.is_deleted' => Model::IS_DELETED_0, 'ft.is_deleted' => Model::IS_DELETED_0])
            ->andWhere(['in', 'ft.code', $templateCodeList])
            ->orderBy(['ftm.field_id' => SORT_ASC, 'ftm.field_required' => SORT_DESC])
            ->createCommand()
            ->queryAll();
    }

    /**
     * 获取模板下的组id
     * @param $FieldTemplateCode
     * @return array
     */
    public function getFieldTemplateGroupIds($FieldTemplateCode = [])
    {
        return FieldTemplateEntity::find()->alias('a')
            ->select('b.group_id')
            ->innerJoin(FieldTemplateMapEntity::tableName() . ' as b', 'a.id=b.template_id and b.is_deleted=0')
            ->distinct()
            ->where(['a.is_deleted' => Model::IS_DELETED_0])
            ->andWhere(['in', 'a.code', $FieldTemplateCode])
            ->createCommand()->queryAll();
    }
}