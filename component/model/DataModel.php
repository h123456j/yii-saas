<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/9/21
 * Time: 11:45
 */

namespace app\component\model;


use yii\base\Model;

class DataModel extends Model
{

    /**
     * 字段别名
     * @var array
     */
    public $fieldsAlias = [];

    public function __construct($config = [])
    {
        if (is_string($config)) {
            $this->setScenario($config);
            $this->init();
        } elseif (is_array($config) || is_object($config)) {
            $this->loadData($config);
            $this->init();
        } else {
            parent::__construct($config);
        }
    }

    public function canSetProperty($name, $checkVar = false, $checkBehavior = false)
    {
        if (method_exists($this, 'set' . $name) || method_exists($this, 'set' . str_replace('_', '', $name)))
            return true;
        return false;
    }

    /**
     * 增加下划线转驼峰格式与自定义别名格式的set方法
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        $method = 'set' . str_replace('_', '', $name);
        if (method_exists($this, $method)) {
            $this->$method($value);
            return;
        } elseif (isset($this->fieldsAlias[$name])) {
            parent::__set($this->fieldsAlias[$name], $value);
            return;
        }
        parent::__set($name, $value);
    }

    /**
     *增加下划线转驼峰格式与自定义别名格式的get方法
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        $method = 'get' . str_replace('_', '', $name);
        if (method_exists($this, $method)) {
            return $this->$method();
        } elseif (isset($this->fieldsAlias[$name])) {
            return parent::__get($this->fieldsAlias[$name]);
        }
        return parent::__get($name);
    }

    /**
     * model数据装载
     * @param $data
     * @param $data1
     * @return $this
     */
    public function loadData($data, $data1)
    {
        if (func_num_args() > 0) {
            foreach (func_get_args() as $item) {
                if (is_array($item) || is_object($item)) {
                    foreach ($item as $k => $v) {
                        if ($this->canSetProperty($k, false) || (new  \ReflectionClass($this))->hasProperty($k)->isPublic()) {
                            $this->$k = $v;
                        }
                    }
                }
            }
        }
        return $this;
    }

    /**
     * 基于场景的映射列表
     * @return [
     *     'scenario_1'=>[
     *           '映射1'=>'属性',
     *           '映射2'=>function(){
     *               return ;
     *               }
     *         ]
     *     'scenario_2'=>[]
     *     ...
     * ]
     */
    public function scenarioFields()
    {
        return [];
    }

    public function fields()
    {
        $fields = $this->scenarioFields();
        if (empty($fields))
            return parent::fields();
        return isset($fields[$this->scenario]) ? $fields[$this->scenario] : array_shift($fields);
    }


}