

<div>
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
            <td></td>
        </tr>
        <?php }}?>
        </tbody>
    </table>

    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination'=>$pages]);?>
    </div>
</div>