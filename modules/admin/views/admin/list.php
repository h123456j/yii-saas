

<div>
    <div class="form-inline">
        <button class="btn btn-primary content-modal" data-title="新增管理员"
                data-url="<?php echo \app\component\helpers\Util::getUrl('admin/update');?>">添加管理员</button>
    </div>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>管理员ID</th>
            <th>账号名</th>
            <th>手机号</th>
            <th>邮箱地址</th>
            <th>用户组</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($data)){
            foreach($data as $item){
        ?>
        <tr>
            <td><?php echo  $item->uid;?></td>
            <td><?php echo  $item->username;?></td>
            <td><?php echo  $item->mobile;?></td>
            <td><?php echo $item->email;?></td>
            <td><?php echo  $item->groupName;?></td>
            <td><?php echo  $item->update_time;?></td>
            <td>
                <span data-title="编辑用户信息" data-url="<?php echo \app\component\helpers\Util::getUrl('admin/update',['id'=>$item['uid']]);?>" style="color: #1465AC;padding: 0 5px;" class="content-modal glyphicon glyphicon-pencil"></span>
                |<span data-url="<?php echo \app\component\helpers\Util::getUrl('admin/del')?>" data-params='{"uid":"<?php echo $item->uid;?>"}' style="color: #FF0000;padding: 0 5px;" class="ajax-del glyphicon glyphicon-trash"></span>
            </td>
        </tr>
        <?php }}?>
        </tbody>
    </table>

    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pages]);?>
    </div>
</div>