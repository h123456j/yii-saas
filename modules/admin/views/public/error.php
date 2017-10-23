<?php
use yii\helpers\Url;

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>服务器故障</title>
</head>
<body>
<style type="text/css">
    body{
        overflow: hidden;
    }
    img{
        width: 100%;
        height:100%;
    }
    .message{
        position: absolute;
        left: 40%;
        top:15%;
        color: #5E6249;
        font-size: 3em;
        font-weight: bold;
    }
</style>
<div class="system-message">
    <p class="message">服务器故障</p>
    <img  src="<?php echo Yii::$app->request->getHostInfo() . '/static/images/50x.jpg'; ?>" alt=""/>
</div>
</body>
</html>
