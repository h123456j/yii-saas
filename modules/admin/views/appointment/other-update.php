<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/10
 * Time: 23:57
 */

use \app\component\helpers\Util;
use \app\models\OtherAppointment;

\backend\assets\AppAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php
    if ($look) { ?>
        <table class="table table-bordered look-table">
            <thead>
            <th>预约详细信息</th>
            </thead>
            <tbody>
            <tr>
                <td>联系人：<span><?php echo $data->contacts; ?></span></td>
            </tr>
            <tr>
                <td>联系电话：<span><?php echo $data->contacts_tel; ?></span></td>
            </tr>
            <tr>
                <td>预约类别：<span><?php echo OtherAppointment::$cateDesc[$data->cate]; ?></span></td>
            </tr>
            <tr>
                <td>备注：<span><?php echo $data->remark; ?></span></td>
            </tr>
            <tr>
                <td>附件：<span><?php
                        if (!empty($data->files)) {
                            $temp = explode(',', $data->files);
                            foreach ($temp as $key => $item) {
                                echo "<a  href='" . Util::getFileUrl($item) . "' target='_blank' class='download-file' >附件-" . $key . " </a>&nbsp;&nbsp;";
                            }
                        }
                        ?></span></td>
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
    <?php } else {
        $form = \yii\bootstrap\ActiveForm::begin([
            'options' => [
                'role' => 'form',
                'class' => 'form-horizontal ajax-form close-content-modal',
                'enctype' => 'multipart/form-data'
            ]
        ]);
        echo $form->field($data, 'contacts')->input('text')->label('借款联系人');
        echo $form->field($data, 'contacts_tel')->input('text')->label('联系人电话');
        echo $form->field($data,'cate')->dropDownList(OtherAppointment::$cateDesc)->label('预约类别');
        echo $form->field($data, 'status')->dropDownList(\app\services\AppointmentService::$statusDesc)->label("审核状态");
        echo $form->field($data, 'remark')->textarea(['style' => 'height:100px;'])->label('备注');
        echo \common\widgets\common\FormFooterWidget::widget([]);
        $form->end();
    }
    ?>
</div>
