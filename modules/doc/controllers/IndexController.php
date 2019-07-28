<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/2
 * Time: 23:01
 */

namespace doc\controllers;

use app\models\FieldDetailOperation;
use app\models\FieldGroupOperation;
use app\models\FieldTemplateOperation;
use app\models\table\FieldTemplateMapEntity;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class IndexController extends Controller
{

    public $layout = '/api/main';

    public function actionIndex()
    {
        $controllers = $this->getControllers();
        ArrayHelper::multisort($controllers,'rank',SORT_DESC);
        return $this->render('index', ['controllers' => $controllers]);
    }

    /**
     * 获取控制器
     * @param string $module
     * @return array
     */
    protected function getControllers($module = 'api')
    {
        $controllers = [];
        $dirs = scandir(\Yii::getAlias('@' . $module . '/controllers'));
        if (!empty($dirs)) {
            foreach ($dirs as $item) {
                if ($item == '.' || $item == '..')
                    continue;
                $class = 'api\\controllers\\' . substr($item, 0, -4);
                $rc = new \ReflectionClass($class);
                $methodList = $rc->getMethods(\ReflectionMethod::IS_PUBLIC);
                $actions = [];
                if (!empty($methodList)) {
                    foreach ($methodList as $method) {
                        $name = $method->getName();
                        if (!strncasecmp($name, 'action', 6) && $name != 'actions') {
                            $actionName = $actionName = strtolower(substr($name, 6));
                            $properties = $this->extractComments($method->getDocComment());
                            $actions[$actionName] = array_merge([
                                'id' => $actionName,
                                'name' => '未填写name',
                                'method' => 'GET',
                                'url' => '',
                                'param' => [],
                                'response' => ''
                            ], $properties);
                        }
                    }
                }

                $controllers[substr($class, 0, -10)] = array_merge([
                    'id' => substr($class, 0, -10),
                    'rank'=>0,
                    'actions' => $actions,
                    'name' => '未填写name'
                ], self::extractComments($rc->getDocComment(), 'controller-'));

            }
        }
        return $controllers;
    }

    /**
     * 提取注释内容
     * @param $comments
     * @param string $prefix
     * @return array
     */
    protected static function extractComments($comments, $prefix = 'api-')
    {
        $properties = [];
        if (preg_match_all('/@' . $prefix . '([a-zA-Z]+)\b([^@]+)/u', $comments, $matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $propertyName = $matches[1][$i];
                if (in_array($propertyName, ['param'])) {
                    $properties[$matches[1][$i]][] = self::extractParamInfo(str_replace('*', '', trim($matches[2][$i], '/')));
                } else {
                    $p = trim(str_replace('*', '', trim($matches[2][$i], '/')));
                    if (in_array($propertyName, ['response'])) {
                        $p=str_replace(' ','&nbsp;',$p);
                        $p = nl2br($p);
                    }
                    $properties[$matches[1][$i]] = $p;
                }
            }
        }
        return $properties;
    }

    /**
     * 提取接口参数
     * @param $paramInfo
     * @return array
     */
    protected static function extractParamInfo($paramInfo)
    {
        if (empty($paramInfo))
            return [];
        $param = [
            'type' => 'unknown',
            'name' => 'unknown',
            'default' => null,
            'brief' => '未填写'
        ];
        $part = explode(' ', trim($paramInfo));
        $param['type'] = array_shift($part);
        $param['name'] = str_replace('$','',array_shift($part));
        $param['brief'] = implode(' ',$part);
        return $param;
    }

    /**
     * 属性配置列表
     * @return string
     */
    public function actionFieldList()
    {
        $this->layout = false;
        $groupList = (new FieldGroupOperation())->getGroupList('archive');
        $groupIds = array_column($groupList, 'group_id');
        $groupList = ArrayHelper::index($groupList, 'group_id');
        $result = (new FieldDetailOperation())->getFieldDetailList($groupIds);
        $fieldList = [];
        foreach ($result as $item) {
            $groupId = $item['group_id'];
            if (!isset($fieldList[$groupId])) {
                $fieldList[$groupId]['group_name'] = $groupList[$groupId]['name_chn'];
            }
            $fieldList[$groupId]['data'][] = [
                'id' => $item['id'],
                'tab_id' => $groupList[$groupId]['tab_id'],
                'name_eng' => $item['name_eng'],
                'module_name' => $item['module_name'],
                'module_id' => $item['module_id'],
                'name_chn' => $item['name_chn']
            ];
        }
        $fieldTemplate = (new FieldTemplateOperation())->getFieldTemplateList();
        $url = "";
        return $this->render('field-list', ['fieldList' => $fieldList, 'fieldTemplate' => $fieldTemplate, 'url' => $url]);
    }

    public function actionDealFields()
    {
        try {
            $templateId = \Yii::$app->request->post('templateId');
            $data = trim(\Yii::$app->request->post('data'));
            $fieldArray = explode(',', $data);
            $saveData = [];
            foreach ($fieldArray as $item) {
                if (empty($item)) {
                    continue;
                }
                $temp = explode('-', $item);
                $entity = FieldTemplateMapEntity::findOne(['template_id' => $templateId, 'field_id' => $temp[3], 'is_deleted' => Model::IS_DELETED_0]);
                if ($entity) {
                    continue;
                }
                $saveData[$temp[3]] = [
                    'template_id' => $templateId,
                    'tab_id' => $temp[0],
                    'group_id' => $temp[1],
                    'module_id' => $temp[2],
                    'field_id' => $temp[3],
                    'field_name' => $temp[4]
                ];
            }
            $fields = array_keys(current($saveData));
            FieldTemplateMapEntity::getDb()->createCommand()->batchInsert(FieldTemplateMapEntity::tableName(), $fields, $saveData)->execute();
            return json_encode(["result"=>true]);
        } catch (\Exception $ex) {
            return json_encode(["result"=>false,"message"=>"服务繁忙"]);
        }
    }

}