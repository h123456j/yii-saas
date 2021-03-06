<?php
\backend\assets\MenuAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php $form = \yii\bootstrap\ActiveForm::begin([
        'options' => [
            'role' => 'form',
            'class' => 'form-horizontal ajax-form close-content-modal',
            'enctype' => 'multipart/form-data'
        ]
    ]);
    if($menu->pid>0)
        echo $form->field($menu,'parentDesc')->input('text',['readonly'=>true])->label('父节点');
    echo $form->field($menu, 'title')->input('text')->label('导航标题');
    echo $form->field($menu, 'url')->input('text')->label('导航栏地址【选填参数,为导航目录是可以留空】');
    echo $form->field($menu, 'hide')->dropDownList(['显示', '隐藏'])->label('显示状态');
    echo $form->field($menu,'sort')->input('text')->label('排序参数【数值越大，排序越后】');
    echo $form->field($menu, 'groupList')->input('text',['id'=>'input-group-list'])->label('所属用户组【选填，默认属于所有用户组】');
    echo \common\widgets\common\FormFooterWidget::widget([]);
    echo $form->field($menu,'id')->input('hidden')->label('');
    echo $form->field($menu,'pid')->input('hidden')->label('');
    echo $form->field($menu, 'group_id')->input('hidden',['id'=>'input-group-id'])->label('');
    $form->end(); ?>
</div>

<div class="div-group-list">
    <div style="height: 90%;overflow: auto;">
        <?php if(!empty($groupList)){
            foreach($groupList as $item){?>
                <li id="group-<?php echo $item->group_id;?>" class="li-group" data-id="<?php echo $item->group_id; ?>"><?php echo $item->title; ?></li>
        <?php }}?>
    </div>
    <div class="div-footer">
        <button class="btn btn-danger group-close">关闭</button>
        <button class="btn btn-default group-reset">重置</button>
        <button class="btn btn-primary group-confirm">确定</button>
    </div>
</div>

