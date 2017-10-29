<?php
\backend\assets\AppAsset::register($this);
\app\assets\DateTimePickerAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php
    $form=\yii\bootstrap\ActiveForm::begin([
        'options' => [
            'role' => 'form',
            'class' => 'form-horizontal ajax-form close-content-modal',
            'enctype' => 'multipart/form-data'
        ]
    ]);
    if(empty($data->date)){
        echo $form->field($data,'startDate')->input('text',['class'=>'datetimepick form-control'])->label('开始日期');
        echo $form->field($data,'endDate')->input('text',['class'=>'datetimepick form-control'])->label('结束日期【选填，默认与开始日期一致】');
    }else{
        echo $form->field($data,'date')->input('text',['readonly'=>true])->label('日期');
    }
    echo $form->field($data,'total_money')->input('text')->label('总金额【 万】');
    echo \common\widgets\common\FormFooterWidget::widget([]);
    $form->end();
    ?>
</div>
