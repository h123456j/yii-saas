
<?php
\backend\assets\AppAsset::register($this);
?>
<div id="form-body" class="col-md-12">
<?php
$form=\yii\bootstrap\ActiveForm::begin([
    'options'=>[
        'role' => 'form',
        'class' => 'form-horizontal ajax-form close-content-modal',
        'enctype' => 'multipart/form-data'
    ]
]);
echo $form->field($data,'title')->input('text')->label('用户组标签');
$readOnly=false;
if($data->name==\backend\models\Admin::SYSTEM_GROUP_NAME)
    $readOnly=true;
echo $form->field($data,'name')->input('text',['readOnly'=>$readOnly])->label('用户组名称【勿使用中文】');
echo $form->field($data,'status')->dropDownList(\backend\models\UserGroup::$statusDesc)->label('是否启用');
echo \common\widgets\common\FormFooterWidget::widget([]);
$form->end();
?>
</div>