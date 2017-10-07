<?php

namespace common\core;

use Yii;

/**
 * AR基类
 * @author phphome@qq.com
 */
class BaseActiveRecord extends \yii\db\ActiveRecord
{

    public function __construct($config=[])
    {
        if(is_string($config)){
            $this->setScenario($config);
            $this->init();
        }elseif(is_array($config)){
            $this->setAttributes($config,false);
            $this->init();
        }else{
            parent::__construct($config);
        }
    }

    /**
     * 场景映射列表
     * return [
     *      'scenario_1'=>[
     *          '映射字段'=>'属性'
     *          '映射字段'=>function(){
     *          }
     *      ]
     *      'scenario_2'=>[
     *           ....
     *       ]
     *       ......
     *  ]
     * @return array
     */
    public function scenarioFields()
    {
        return [];
    }

    public function fields()
    {
        $fields=$this->scenarioFields();
        if(empty($fields))
            return parent::fields();

        return isset($fields[$this->scenario])?$fields[$this->scenario]:array_shift($fields);
    }


}
