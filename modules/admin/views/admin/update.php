<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/28
 * Time: 18:30
 */
?>

<div id="form-body" class="col-md-12">
    <?php
    $form = \yii\bootstrap\ActiveForm::begin([
        'options' => [
            'role' => 'form',
            'class' => 'form-horizontal ajax-form close-content-modal',
            'enctype' => 'multipart/form-data'
        ]
    ]);

    echo $form->field($data, 'username')->input('text')->label('管理员登录名【勿使用中文】');
    $label='管理员登录密码';
    if(!empty($data->uid))
        $label.='【留空表示不修改密码】';
    echo $form->field($data, 'tempPassword')->input('text', ['value' => ''])->label($label);
    echo $form->field($data, 'email')->input('text')->label('邮箱【选填】');
    echo $form->field($data, 'mobile')->input('text')->label('手机号');
    echo $form->field($data, 'group_id')->dropDownList($groupList)->label('所属用户组');
    ?>
    <div class="form-inline" style="text-align: center;">
        <button class="btn btn-danger" type="button" onclick="parent.ContentModal.closeContentModal()">关&nbsp;闭</button>
        <button class="btn btn-primary" style="margin-left: 30px;" type="submit">提&nbsp;交</button>
    </div>
    <?php
    echo $form->field($data, 'uid')->input('hidden')->label('');
    $form->end();
    ?>
</div>
