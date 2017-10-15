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
        color: #ffffff;
        border-bottom: 1px double #ffffff;
        background-color: #0a6aa1;
    }

    .li-action {
        line-height: 35px;
        font-size: 14px;
        border-top: 1px double #C0C9CC;
    }

    .div-global {
        width: 1250px;
        margin: auto;
        min-height: 800px;
        display: table;
    }

    .div-top {
        width: 1250px;
        padding-left: 20px;
        margin: 5px 0 5px 0;
        background-color: #F8F8F8;
        min-height: 10px;
        display: table;
    }

    .div-left {
        width: 200px;
        overflow: hidden;
        background-color: #F8F8F8;
        float: left;
    }

    .div-right {
        padding: 20px 20px 20px 20px;
        font-size: 15px !important;
        width: 1045px;
        display: table;
        float: left;
        margin-left: 5px;
        min-height: 800px;
        display: table;
        background-color: #F8F8F8;
    }

    .font-red {
        color: #FF0000;
    }

    .doc-top {
        width: 100%;
        min-height: 100px;
        border-bottom: 1px double #0a2640;
    }
</style>
<div class="div-global">
    <div class="div-top">
        <h3>接口域名[host]:<?php echo Yii::$app->params['api']['host']; ?></h3>
    </div>
    <div class="div-left">
        <?php
        $ck = 0;
        foreach ($controllers as $controller) { ?>
            <div>
                <li class="li-controller"><?php echo $controller['name'] ?></li>
                <?php foreach ($controller['actions'] as $ak => $action) { ?>
                    <li class="li-action" data-json='<?php echo json_encode($action); ?>'>
                        &nbsp;&nbsp;&nbsp;<?php echo $action['name'] ?></li>
                <?php } ?>
            </div>
            <?php $ck++;
        } ?>
    </div>
    <div class="div-right">
        <div class="doc-top">
            <p style="text-align: center;font-size: 18px;font-weight: bold;">接口请求公共参数约定</p>
            <h4>page:页码，选填，默认为1 pageSize 每页数据条数,选填,默认20</h4>

            <p style="text-align: center;font-size: 18px;font-weight: bold;">接口返回公共参数约定</p>
            <h4>成功返回:{"status":1,"result":{"data":"返回数据","sid":"登录用户会话id","nonce":1507960717[时间戳]}}</h4>
            <h4>失败返回:{"status":0,"result":{"code":null[错误码],"message":null[错误描述],"sid":"","nonce":1507960729}}</h4>
            <h4>分页对象:"page": {"current": 1,[当前页]"total": 1,[总页数]"count": 1,[总条数]"size": 20,[每页展示条数]}</h4>
            <h4>部分异常返回说明：100000=>'数据库故障','100001'=>'未知错误','100003'=>'签名错误','100004'=>'非法参数'</h4>
            <h4>'300000'=>'用户未登录','300001'=>'登录态失效'</h4>
        </div>

        <h4>接口签名生成规则说明(每次请求接口时带上签名参数sign=''):</h4>

        <h4>设备授权密钥 [secretKey]:17eaf9a57c751b340d502734c29e4735</h4>

        <h4>接口地址 [uri]:index/get-list</h4>

        <h4>请求方式 [method]:get</h4>

        <h4>请求参数数组 [params]:["cate"=>1,"page"=>1,"pageSize"=>10,"amend"=>true]</h4>

        <h4>当前时间 [dataTime]:2017-10-05 16:37 精确到分并转换成时间戳格式(381507279080)</h4>

        <h4>1、对参数数组params按照键名升序处理
            <span style="color: #FF0000;">["amend"=>true,"cate"=>1,"page"=>1,"pageSize"=>10]</span>
        </h4>

        <h4>2、将排序后参数参数进行字符链接[params](
            <span style="color: #FF0000;">amend=true&cate=1&page=1&pageSize=10</span>
            )
        </h4>

        <h4>3、签名字符串处理[signString]:host+'/'+'uri+'&'+method'+'&'params (
            <span style="color: #FF0000;">http://yii-admin.com/api/index/get-list&get&amend=true&cate=1&page=1&pageSize=10</span>
            )
        </h4>

        <h4>4、将signString字符串转换成小写 (
            <span
                class="font-red">http://yii-admin.com/api/index/get-list&get&amend=true&cate=1&page=1&pagesize=10</span>
            )
        </h4>

        <h4>5、拼接设备授权密钥与时间组装签名[key]:signString&secretKey&dateTime (
            <span class="font-red">http://yii-admin.com/api/index/get-list&get&amend=true&cate=1&page=1&pagesize=10&17eaf9a57c751b340d502734c29e4735&1507280820</span>
        </h4>

        <h4>6、生成签名[sign]:md5(key)
            <span class="font-red">bc0a6894d75c723276a8c51ece760457</span>
        </h4>
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
            <th style="min-width: 100px;">参数名</th>
            <th style="min-width: 100px;">参数类型</th>
            <th>注释</th>
        </tr>
        <% for(var i=0;i
        <param.length ;i++){%>
            <tr>
                <td><%=param[i].name%></td>
                <td><%=param[i].type%></td>
                <td><%=#param[i].brief%></td>
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

