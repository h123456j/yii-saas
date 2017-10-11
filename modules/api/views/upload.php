<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/10
 * Time: 14:35
 */

$form=\yii\bootstrap\ActiveForm::begin([
    'options'=>[
        'form'=>'',
        'enctype'=>'multipart/form-data'
    ]
]);
?>


<input name="files[]" type="file">
<input name="files[]" type="file">
<button type="submit">提交</button>
<?php $form::end();?>
