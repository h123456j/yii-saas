<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/2
 * Time: 23:01
 */

namespace doc\controllers;


use yii\helpers\VarDumper;
use yii\web\Controller;

class IndexController extends Controller
{

    public $layout='/api/main';

    public function actionIndex()
    {
        $controllers = $this->getControllers();
//        VarDumper::dump($controllers,10,true);die;
//        header('Content-Type: application/json');
//        echo json_encode($controllers);die;
        return $this->render('index',['controllers'=>$controllers]);
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
                                'name' => '未填写name'
                            ], $properties);
                        }
                    }
                }

                $controllers[substr($class, 0, -10)] = array_merge([
                    'id' => substr($class, 0, -10),
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
        if (!empty($part[0]))
            $param['type'] = $part[0];
        if (!empty($part[1]))
            $param['name'] = $part[1];
        if (!empty($part[2]))
            $param['brief'] = $part[2];
        $param['name'] = str_replace('$', '', $param['name']);
        return $param;
    }

}