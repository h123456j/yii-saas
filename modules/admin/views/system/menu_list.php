<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/9/16
 * Time: 17:36
 */
\backend\assets\MenuAsset::register($this);
?>
<style type="text/css">
    tr,td{
        cursor: pointer;
    }
</style>
<div class="table-responsive">
    <table class="table">
        <thead>
        <th>导航栏标题</th>
        <th>操&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作</th>
        </thead>
        <tbody id="menu-list-body">

        </tbody>
    </table>
</div>

<script type="text/javascript">
    var json='<?php echo  json_encode($data);?>';
</script>
