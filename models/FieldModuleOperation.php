<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/15
 * Time: 20:50
 */

namespace app\models;

use app\models\table\FieldModuleEntity;

class FieldModuleOperation extends FieldModuleEntity
{

    /**
     * 获取模块列表
     * @param $groupIds
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getModuleListByGroupIds($groupIds)
    {
        return FieldModuleEntity::find()
            ->select('id,group_id,module_name,module_code,widget,extra,module_type,module_service')
            ->where(['is_show' => 1, 'is_deleted' => self::IS_DELETED_0])
            ->andWhere(['in', 'group_id', $groupIds])
            ->asArray()
            ->all();
    }

    /**
     * 获取扩展列表
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSupplierExtendListTable()
    {
        return FieldModuleEntity::find()
            ->alias('fdm')
            ->select('fdm.id,fdm.group_id,fdt.table_name')
            ->innerJoin(FieldDetailEntity::tableName() . ' fdt', 'fdm.id=fdt.module_id')
            ->where(['fdm.module_service' => 'supplier_extend_list', 'fdm.is_deleted' => self::IS_DELETED_0, 'fdt.is_deleted' => Model::IS_DELETED_0])
            ->asArray()
            ->all();
    }

    /**
     * 根据id批量获取模块列表
     * @param $moduleIdList
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getModuleListByIds($moduleIdList)
    {
        return FieldModuleEntity::find()
            ->select('id,group_id,module_name,module_code,widget,extra,module_type,module_service')
            ->where(['is_show' => 1, 'is_deleted' => self::IS_DELETED_0])
            ->andWhere(['in', 'id', $moduleIdList])
            ->orderBy(['sort' => SORT_ASC])
            ->asArray()
            ->all();
    }

}
