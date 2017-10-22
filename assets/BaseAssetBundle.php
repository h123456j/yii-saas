<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/19
 * Time: 14:24
 */

namespace app\assets;


use yii\helpers\ArrayHelper;
use yii\web\AssetBundle;

class BaseAssetBundle extends AssetBundle
{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    private static $updateTime = '2017-10';


    /**
     * Initializes the bundle.
     * If you override this method, make sure you call the parent implementation in the last.
     */
    public function init()
    {
        self::$updateTime = \Yii::$app->params['update_time'];

        if ($this->sourcePath !== null) {
            $this->sourcePath = rtrim(\Yii::getAlias($this->sourcePath), '/\\');
        }
        if ($this->basePath !== null) {
            $this->basePath = rtrim(\Yii::getAlias($this->basePath), '/\\');
        }
        if ($this->baseUrl !== null) {
            $this->baseUrl = rtrim(\Yii::getAlias($this->baseUrl), '/');
        }
    }

    /**
     * 新增版本号处理
     * Registers the CSS and JS files with the given view.
     * @param \yii\web\View $view the view that the asset files are to be registered with.
     */
    public function registerAssetFiles($view)
    {
        $manager = $view->getAssetManager();
        foreach ($this->js as $js) {
            if (is_array($js)) {
                $file = array_shift($js);
                $file = self::dealFile($file);
                $options = ArrayHelper::merge($this->jsOptions, $js);
                $view->registerJsFile($manager->getAssetUrl($this, $file), $options);
            } else {
                if ($js !== null) {
                    $js = self::dealFile($js);
                    $view->registerJsFile($manager->getAssetUrl($this, $js), $this->jsOptions);
                }
            }
        }
        foreach ($this->css as $css) {
            if (is_array($css)) {
                $file = array_shift($css);
                $file = self::dealFile($file);
                $options = ArrayHelper::merge($this->cssOptions, $css);
                $view->registerCssFile($manager->getAssetUrl($this, $file), $options);
            } else {
                if ($css !== null) {
                    $css = self::dealFile($css);
                    $view->registerCssFile($manager->getAssetUrl($this, $css), $this->cssOptions);
                }
            }
        }
    }

    /**
     * 更新时间参数处理
     * @param $file
     * @return string
     */
    protected static function dealFile($file)
    {
        return strpos($file, '?') === false ? $file . '?update_time=' . time(): $file . '&update_time=' . time();
    }

}