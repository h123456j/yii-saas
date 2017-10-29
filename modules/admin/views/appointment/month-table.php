<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/29
 * Time: 15:04
 */
?>

<div class="table-responsive">
    <div class="form-inline">
        <button data-title="新增排期信息" data-url="<?php echo \app\component\helpers\Util::getUrl('appointment/schedule-update');?>" class="content-modal btn btn-primary">新增排期信息</button>
    </div>
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>日期</th>
            <th>总金额</th>
            <th>冻结金额</th>
            <th>可用金额</th>
            <th>已用金额</th>
            <th>更新时间</th>
            <th>操作人</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($data)){
            foreach($data as $item){
            ?>
                <tr>
                    <td><?php echo $item['date']; ?></td>
                    <td><?php echo $item['total_money'];?></td>
                    <td><?php echo $item['freeze_money'];?></td>
                    <td><?php echo $item['usable_money'];?></td>
                    <td><?php echo $item['use_money'];?></td>
                    <td><?php echo $item['update_time'];?></td>
                    <td><?php echo $item['update_people'];?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams'=>[
                                'title'=>'排期信息更新',
                                'url'=>'appointment/schedule-update',
                                'params'=>['date'=>$item['date']]
                            ]
                        ]);
                        ?>
                    </td>
                </tr>
        <?php }}?>
        </tbody>
    </table>

    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>
