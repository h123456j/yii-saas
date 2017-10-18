<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/18
 * Time: 17:28
 */

namespace app\component\widgets;


use yii\helpers\Json;
use yii\widgets\ActiveFormAsset;

class ActiveForm extends \yii\bootstrap\ActiveForm
{
    
    public $autoLoadJs = false;

    /**
     * 重写基类方法，不自动加载yii自带的js资源文件
     * This registers the necessary JavaScript code.
     * @since 2.0.12
     */
    public function registerClientScript()
    {
        if ($this->autoLoadJs) {
            $id = $this->options['id'];
            $options = Json::htmlEncode($this->getClientOptions());
            $attributes = Json::htmlEncode($this->attributes);
            $view = $this->getView();
            ActiveFormAsset::register($view);
            $view->registerJs("jQuery('#$id').yiiActiveForm($attributes, $options);");
        }
    }

}