<?php

?>
<div class="table-responsive">
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>预约人</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>职业</th>
            <th>楼盘名称</th>
            <th>资金缺口(万)</th>
            <th>使用天数(天)</th>
            <th>创建时间</th>
            <th>审核状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (is_array($data)) {
            foreach ($data as $item) {
                ?>
                <tr>
                    <td><?php echo $item->nickname;?></td>
                    <td><?php echo $item->contacts;?></td>
                    <td><?php echo $item->contacts_tel;?></td>
                    <td><?php echo $item->profession;?></td>
                    <td><?php echo $item->building_name;?></td>
                    <td><?php echo $item->money;?></td>
                    <td><?php echo $item->usage_days;?></td>
                    <td><?php echo $item->create_time;?></td>
                    <td><?php echo \app\models\BridgeLoanAppointment::$statusDesc[$item->status]?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams'=>[
                                'title'=>'信息更新',
                                'url'=>'appointment/redeem-building-update',
                                'params'=>['id'=>$item['id']]
                            ],
                            'lookParams'=>[
                                'title'=>'信息查看',
                                'url'=>'appointment/redeem-building-update',
                                'params'=>['id'=>$item['id'],'look'=>true]
                            ],
                            'delParams'=>[
                                'url'=>'appointment/del',
                                'params'=>[
                                    'id'=>$item['id'],
                                    'type'=>\app\services\HomePageService::APPOINTMENT_TYPE_FOR_REDEEM_BUILDING
                                ]
                            ]
                        ])
                        ?>
                    </td>
                </tr>
                <?php
            }
        } ?>
        </tbody>
    </table>
    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>