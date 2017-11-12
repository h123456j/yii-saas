<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/10
 * Time: 23:57
 */

use \app\models\EstateAppointment;

\backend\assets\AppAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php
    if ($look) {?>
        <table class="table table-bordered">
            <thead>
            <th></th>
            </thead>
            <tbody>
            <tr>
                <td>业主:</td>
                <td><?php echo  $data->owner;?></td>
            </tr>
            <tr>
                <td>联系人:</td>
                <td><?php echo $data->contacts;?></td>
            </tr>
            <tr>
                <td>联系电话:</td>
                <td><?php echo $data->contacts_tel;?></td>
            </tr>
            <tr>
                <td>建筑类别:</td>
                <td><?php echo  EstateAppointment::$cateDesc[$data->cate];?></td>
            </tr>
            </tbody>
        </table>
    <?php} else {
        $form = \yii\bootstrap\ActiveForm::begin([
            'options' => [
                'role' => 'form',
                'class' => 'form-horizontal ajax-form close-content-modal',
                'enctype' => 'multipart/form-data'
            ]
        ]);
        echo $form->field($data, 'owner')->input('text')->label('业主');
        echo $form->field($data, 'contacts')->input('text')->label('借款联系人');
        echo $form->field($data, 'contacts_tel')->input('text')->label('联系人电话');
        echo $form->field($data, 'cate')->dropDownList(EstateAppointment::$cateDesc)->label('建筑类别');
        echo $form->field($data, 'cate_property')->dropDownList(EstateAppointment::$catePropertyDesc)->label('类别属性');
        echo $form->field($data, 'property')->dropDownList(EstateAppointment::$propertyDesc)->label('建筑属性');
        echo $form->field($data, 'land_area')->input('text')->label('占地面积(平米)');
        echo $form->field($data, 'building_area')->input('text')->label('建筑面积(平米)');
        echo $form->field($data, 'status')->dropDownList(\app\services\AppointmentService::$statusDesc)->label("审核状态");
        echo $form->field($data, 'remark')->textarea(['style' => 'height:100px;'])->label('备注');
        echo \common\widgets\common\FormFooterWidget::widget([]);
        $form->end();
    }
    ?>
</div>
