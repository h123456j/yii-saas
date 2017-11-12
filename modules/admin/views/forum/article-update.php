<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/10
 * Time: 23:57
 */

use \app\component\helpers\Util;
use \app\models\ArticleInfo;

\backend\assets\AppAsset::register($this);
?>

<div id="form-body" class="col-md-12">
    <?php
    if ($look) { ?>
        <table class="table table-bordered look-table">
            <thead>
            <th>文章详细信息</th>
            </thead>
            <tbody>
            <tr>
                <td>文章logo：<span><?php echo empty($data->logo)?null:"<a  href='" . Util::getFileUrl($data->logo) . "' target='_blank' class='download-file' >查看</a>"; ?></span></td>
            </tr>
            <tr>
                <td>标题：<span><?php echo $data->title; ?></span></td>
            </tr>
            <tr>
                <td>作者：<span><?php echo $data->author; ?></span></td>
            </tr>
            <tr>
                <td>审核状态：<span><?php echo ArticleInfo::$statusDesc[$data->status];?></span></td>
            </tr>
            <tr>
                <td>阅读数：<span><?php echo $data->look_num;?>&nbsp;次</span></td>
            </tr>
            <tr>
                <td>评论数：<span><?php echo $data->comment_num;?>&nbsp;条</span></td>
            </tr>
            <tr>
                <td style="text-align: center">文章内容</td>
            </tr>
            <tr>
                <td><?php echo $data->content;?></td>
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
        echo $form->field($data,'cate_code')->dropDownList(\app\models\ArticleCateModel::getCateList())->label('文章分类');
        echo $form->field($data, 'title')->input('text')->label('文章标题');
        echo $form->field($data, 'status')->dropDownList(\app\models\ArticleInfo::$statusDesc)->label('审核状态');
        echo \common\widgets\common\FormFooterWidget::widget([]);
        $form->end();
    }
    ?>
</div>
