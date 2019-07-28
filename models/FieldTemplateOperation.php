<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2018/7/12
 * Time: 15:13
 */

namespace app\models;

use app\models\table\FieldTemplateEntity;

class FieldTemplateOperation extends FieldTemplateEntity
{

    /**
     * 获取属性模板列表
     * @param int $isShow
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getFieldTemplateList($isShow = null)
    {
        return FieldTemplateEntity::find()
            ->select('id,code,name,sort')
            ->where(['is_deleted' => self::IS_DELETED_0])
            ->andFilterWhere(['is_show' => $isShow])
            ->asArray()
            ->all();
    }

}