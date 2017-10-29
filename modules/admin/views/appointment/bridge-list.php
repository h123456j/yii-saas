<div class="table-responsive">
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>预约人</th>
            <th>借款主体</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>预约金额</th>
            <th>预约日期</th>
            <th>使用天数</th>
            <th>最快用款日</th>
            <th>最后用款日</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (is_array($data)) {
            foreach ($data as $item) {
                ?>
                <tr>
                    <td><?php echo $item->nickname;?></td>
                    <td><?php echo $item->borrower;?></td>
                    <td><?php echo $item->contacts;?></td>
                    <td><?php echo $item->contacts_tel;?></td>
                    <td><?php echo $item->money;?></td>
                    <td><?php echo $item->appointment_date;?></td>
                    <td><?php echo $item->usage_days;?></td>
                    <td><?php echo $item->recently_date;?></td>
                    <td><?php echo $item->last_date;?></td>
                    <td><?php echo \app\models\BridgeLoanAppointment::$statusDesc[$item->status]?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams'=>[
                                'title'=>'信息更新',
                                'url'=>'appointment/bridget-load-update',
                                'params'=>['id'=>$item['id']]
                            ],
                            'delParams'=>[
                                'url'=>'appointment/del',
                                'params'=>[
                                    'id'=>$item['id'],
                                    'type'=>\app\services\HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN
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