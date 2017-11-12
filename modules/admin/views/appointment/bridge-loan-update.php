<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/10
 * Time: 23:57
 */
use \app\models\BridgeLoanAppointment;

\backend\assets\AppAsset::register($this);
\app\assets\DateTimePickerAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php
    if ($look) {
        ?>
        <table class="table table-bordered look-table">
            <thead>
            <th>预约详细信息</th>
            </thead>
            <tbody>
            <tr>
                <td>借款人：<span><?php echo $data->borrower; ?></span></td>
            </tr>
            <tr>
                <td>联系人：<span><?php echo $data->contacts; ?></span></td>
            </tr>
            <tr>
                <td>联系电话：<span><?php echo $data->contacts_tel; ?></span></td>
            </tr>
            <tr>
                <td>预约金额：<span><?php echo $data->money;?></span>&nbsp;万元</td>
            </tr>
            <tr>
                <td>预约日期：<span><?php echo $data->appointment_date; ?></span></td>
            </tr>
            <tr>
                <td>使用天数：<span><?php echo $data->usage_days; ?>&nbsp;天</span></td>
            </tr>
            <tr>
                <td>最快使用日期：<span><?php echo $data->recently_date; ?></span></td>
            </tr>
            <tr>
                <td>最后使用日期：<span><?php echo $data->last_date; ?></span></td>
            </tr>
            <tr>
                <td>属性：<span><?php echo BridgeLoanAppointment::$propertyDesc[$data->property];?></span></td>
            </tr>
            <tr>
                <td>备注：<span><?php echo $data->remark; ?></span></td>
            </tr>
            <tr>
                <td>审核时间：<span><?php echo $data->audit_time; ?></span></td>
            </tr>
            <tr>
                <td>创建时间：<span><?php echo $data->create_time; ?></span></td>
            </tr>
            <tr>
                <td>更新时间：<span><?php echo $data->update_time; ?></span></td>
            </tr>
            </tbody>
        </table>
        <?php
    } else {
        $form = \yii\bootstrap\ActiveForm::begin([
            'options' => [
                'role' => 'form',
                'class' => 'form-horizontal ajax-form close-content-modal',
                'enctype' => 'multipart/form-data'
            ]
        ]);
        echo $form->field($data, 'borrower')->input('text')->label('借款主体');
        echo $form->field($data, 'contacts')->input('text')->label('借款联系人');
        echo $form->field($data, 'contacts_tel')->input('text')->label('联系人电话');
        echo  $form->field($data,'property')->dropDownList(BridgeLoanAppointment::$propertyDesc)->label('属性');
        echo $form->field($data, 'remark')->textarea(['style' => 'height:100px;'])->label('备注');
        echo $form->field($data, 'status')->dropDownList(\app\services\AppointmentService::$statusDesc)->label("审核状态");
        echo \common\widgets\common\FormFooterWidget::widget([]);
        $form->end();
    }
    ?>
</div>
