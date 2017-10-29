<?php
\backend\assets\AppAsset::register($this);
?>
<div class="table-responsive">
    <div class="form-inline">
        <button class="btn btn-primary content-modal" data-title="添加用户组" data-url="<?php echo \app\component\helpers\Util::getUrl('system/group-update'); ?>">添加用户组</button>
    </div>
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>分组id</th>
            <th>标题</th>
            <th>名称</th>
            <th>创建人</th>
            <th>状态</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($data)) {
            foreach ($data as $item) {
                ?>
                <tr>
                    <td><?php echo $item->group_id; ?></td>
                    <td><?php echo $item->title; ?></td>
                    <td><?php echo $item->name; ?></td>
                    <td><?php echo $item->create_people; ?></td>
                    <td><?php echo $item->status = 1 ? '有效' : '禁用'; ?></td>
                    <td><?php echo $item->update_time; ?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams' => [
                                'url' => 'system/group-update',
                                'title' => '管理员信息编辑',
                                'params' => ['id' => $item['group_id']]
                            ],
                            'delParams' => [
                                'url' => 'system/group-del',
                                'params' => ['id' => $item['group_id']]
                            ]
                        ])
                        ?>
                    </td>
                </tr>
            <?php }
        } ?>
        </tbody>
    </table>

    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>
