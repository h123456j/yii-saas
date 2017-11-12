<?php
use \app\models\EstateAppointment;
?>
<div class="table-responsive">
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>预约人</th>
            <th>业主</th>
            <th>联系人</th>
            <th>联系电话</th>
            <th>建筑类别</th>
            <th>类别属性</th>
            <th>占地面积(平米)</th>
            <th>建筑面积(平米)</th>
            <th>属性</th>
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
                    <td><?php echo $item->owner;?></td>
                    <td><?php echo $item->contacts;?></td>
                    <td><?php echo $item->contacts_tel;?></td>
                    <td><?php echo EstateAppointment::$cateDesc[$item->cate];?></td>
                    <td><?php echo EstateAppointment::$catePropertyDesc[$item->cate_property];?></td>
                    <td><?php echo $item->land_area;?></td>
                    <td><?php echo $item->building_area;?></td>
                    <td><?php echo EstateAppointment::$propertyDesc[$item->property];?></td>
                    <td><?php echo $item->create_time;?></td>
                    <td><?php echo \app\models\BridgeLoanAppointment::$statusDesc[$item->status]?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams'=>[
                                'title'=>'信息更新',
                                'url'=>'appointment/estate-update',
                                'params'=>['id'=>$item['id']]
                            ],
                            'lookParams'=>[
                                'title'=>'信息查看',
                                'url'=>'appointment/estate-update',
                                'params'=>['id'=>$item['id'],'look'=>true]
                            ],
                            'delParams'=>[
                                'url'=>'appointment/del',
                                'params'=>[
                                    'id'=>$item['id'],
                                    'type'=>\app\services\HomePageService::APPOINTMENT_TYPE_FOR_ESTATE
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