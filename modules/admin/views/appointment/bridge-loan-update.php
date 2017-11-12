<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/10
 * Time: 23:57
 */

\backend\assets\AppAsset::register($this);
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
    echo  $form->field($bridgeLoan,'borrower')->input('text')->label('借款主体');
    echo  $form->field($bridgeLoan,'contacts')->input('text')->label('借款联系人');
    echo  $form->field($bridgeLoan,'contacts_tel')->input('text')->label('联系人电话');
    echo  $form->field($bridgeLoan,'remark')->textarea(['style'=>'height:100px;'])->label('备注');
    echo  $form->field($bridgeLoan,'status')->dropDownList(\app\services\AppointmentService::$statusDesc)->label("审核状态");
    echo \common\widgets\common\FormFooterWidget::widget([]);
    $form->end();
    ?>
</div>
