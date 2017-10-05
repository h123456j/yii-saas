<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/2
 * Time: 23:04
 */
?>
<style type="text/css">
    li {
        list-style: none;
        cursor: pointer;
    }

    .li-controller {
        padding-left: 10px;
        line-height: 40px;
        font-size: 16px;
        font-weight: bold;
        background-color: #0a6aa1;
    }

    .li-action {
        line-height: 35px;
        font-size: 14px;
        border-top: 1px double #C0C9CC;
    }

    .div-top {
        width: 1206px;
        padding-left: 20px;
        margin-bottom: 10px;
        background-color: #F8F8F8;
        height: 100px;
    }

    .div-left {
        width: 200px;
        overflow: hidden;
        background-color: #F8F8F8;
        float: left;
    }

    .div-right {
        font-size: 15px !important;
        width: 1000px;
        display: table;
        float: left;
        margin-left: 5px;
        min-height: 700px;
        background-color: #F8F8F8;
    }
</style>
<div class="col-lg-12" style="background-color: #c0c0c0;min-height: 700px;">
    <h2 style="text-align: center;">接口文档</h2>

    <div class="div-top">
        <h3>接口地址:<?php echo Yii::$app->params['api']['host']; ?></h3>
    </div>
    <div class="div-left">
        <?php
        foreach ($controllers as $controller) { ?>
            <div>
                <li class="li-controller"><?php echo $controller['name'] ?></li>
                <?php foreach ($controller['actions'] as $action) { ?>
                    <li class="li-action" data-json='<?php echo json_encode($action); ?>'>
                        &nbsp;&nbsp;&nbsp;<?php echo $action['name'] ?></li>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div class="div-right">

    </div>
</div>

<script type="text/html" id="api-doc">
    <table class="table table-bordered">
        <tbody>
        <tr>
            <th colspan="3" style="text-align: center;">接口说明</th>
        </tr>
        <tr>
            <th>接口地址</th>
            <td colspan="2"><%=url %></td>
        </tr>
        <tr>
            <th>请求方式</th>
            <td colspan="2"><%=method%></td>
        </tr>
        <tr>
            <th colspan="3" style="text-align: center;">请求参数说明</th>
        </tr>
        <tr>
            <th>参数名</th>
            <th>参数类型</th>
            <th>注释</th>
        </tr>
        <% for(var i=0;i<param.length;i++){%>
        <tr>
            <td><%=param[i].name%></td>
            <td><%=param[i].type%></td>
            <td><%=param[i].brief%></td>
        </tr>
        <%}%>
        <tr>
            <th colspan="3" style="text-align: center;">返回值说明</th>
        </tr>
        <tr>
            <td colspan="3" style="padding-left: 50px;">
                <%=#response%>
            </td>
        </tr>
        </tbody>
    </table>
</script>

