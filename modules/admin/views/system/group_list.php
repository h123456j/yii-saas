
<div class="table-responsive">
    <div class="form-inline">
        <button class="btn btn-primary" data-target="#content-modal" modal-title="添加用户组" data-remote="<?php echo  Yii::$app->request->getHostInfo().'/admin/system/group-update'?>" data-toggle="modal">添加用户组</button>
    </div>
    <table class="table table-bordered">
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
        <?php if(!empty($data)){
            foreach($data as $item){
                ?>
                <tr>
                    <td><?php echo  $item->group_id;?></td>
                    <td><?php echo  $item->title;?></td>
                    <td><?php echo  $item->name;?></td>
                    <td><?php echo $item->create_people;?></td>
                    <td><?php echo  $item->status=1?'有效':'禁用';?></td>
                    <td><?php echo  $item->update_time;?></td>
                    <td></td>
                </tr>
            <?php }}?>
        </tbody>
    </table>

    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pages]);?>
    </div>
</div>
