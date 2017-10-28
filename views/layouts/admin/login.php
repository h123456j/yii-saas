<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\common\IeAsset::register($this);
\backend\assets\LoginAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $this->title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="管理员登录" name="description"/>
        <?php $this->head() ?>
        <link rel="shortcut icon" href="/favicon.ico"/>
    </head>
    <script language="JavaScript">
        var BaseUrl = '<?=Yii::$app->request->getHostInfo();?>';
    </script>
    <body class="page-container-bg-solid page-md login">
    <?php echo \common\widgets\modal\AlertMessageWidget::widget([]); ?>
    <div id="module-login"></div>
    <div class="div-load"></div>
    <?php
    $this->beginBody();
     echo $content;
    \backend\assets\LayoutAsset::register($this);
    ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>