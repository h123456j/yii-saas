<?php
use yii\helpers\Url;

?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>服务器故障</title>
</head>
<body>
<style type="text/css">
    body {
        overflow: hidden;
    }

    img {
        width: 100%;
        height: 100%;
    }
</style>
<div class="system-message">
    <img src="<?php echo Yii::$app->request->getHostInfo() . '/static/images/50x.jpg'; ?>" alt=""/>
</div>
</body>
</html>
