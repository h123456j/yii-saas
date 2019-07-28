<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/5/8
 * Time: 16:25
 */

namespace app\models;


use app\models\table\FieldGroupEntity;
use app\models\table\FieldTabEntity;

class FieldGroupOperation extends FieldGroupEntity
{

    /**
     *  获取表单分组列表
     * @param string $tabType 标签类型
     * @param null $tabCode 标签code
     * @param array $tabIds 标签id列表
     * @param bool $asArray
     * @param null $indexBy
     * @param null $scenario
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getGroupList($tabType, $tabCode = null, $tabIds = [], $asArray = true, $indexBy = null, $scenario = null)
    {
        $data = FieldGroupEntity::find()
            ->select('dfg.id group_id,dfg.name_eng,dfg.name_chn,dfg.remark,dfg.type group_type,dfg.extra,dfg.tab_id,dft.tab_name,dft.tab_code')
            ->from('d_field_group dfg')
            ->leftJoin(FieldTabEntity::tableName() . ' dft', 'dfg.tab_id=dft.id')
            ->where(['dfg.is_deleted' => self::IS_DELETED_0, 'dfg.is_show' => 1, 'dft.is_deleted' => self::IS_DELETED_0, 'dft.is_show' => 1])
            ->andFilterWhere(['dft.tab_type' => $tabType])
            ->andFilterWhere(['dft.tab_code' => $tabCode])
            ->andFilterWhere(['in', 'dft.id', $tabIds])
            ->orderBy(['dft.sort' => SORT_ASC, 'dfg.sort' => SORT_ASC])
            ->indexBy($indexBy)
            ->asArray($asArray)
            ->all();
        if (is_array($data) && !is_null($scenario)) {
            foreach ($data as &$item) {
                $item->setScenario($scenario);
            }
        }
        return $data;
    }

    /**
     * 根据id获取分组信息
     * @param $groupIds
     * @return array
     */
    public function getGroupListByIds($groupIds)
    {
        return FieldGroupEntity::find()
            ->alias('dfg')
            ->select('dfg.id group_id,dfg.name_eng,dfg.name_chn,dfg.remark,dfg.type group_type,dfg.extra,dfg.tab_id,dft.tab_name,dft.tab_code')
            ->innerJoin(FieldTabEntity::tableName() . ' dft', 'dfg.tab_id=dft.id')
            ->where(['dfg.is_deleted' => self::IS_DELETED_0, 'dfg.is_show' => 1, 'dft.is_deleted' => self::IS_DELETED_0, 'dft.is_show' => 1])
            ->andFilterWhere(['in', 'dfg.id', $groupIds])
            ->orderBy(['dft.sort' => SORT_ASC, 'dfg.sort' => SORT_ASC])
            ->createCommand()
            ->queryAll();
    }

}