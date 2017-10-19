
<?php $this->beginContent('@app/views/layouts/admin/common.php') ?>
<?php $this->endContent() ?>

<!-- 定义数据块 -->
<?php $this->beginBlock('test'); ?>
<?php $this->endBlock() ?>
<!-- 将数据块 注入到视图中的某个位置 -->
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
