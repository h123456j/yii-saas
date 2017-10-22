<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\common\IeAsset::register($this);
\backend\assets\AppAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $this->title; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="网站描述" name="description"/>
        <?php $this->head() ?>
        <link rel="shortcut icon" href="/favicon.ico"/>
        <script language="JavaScript">
            var BaseUrl = '<?echo  Yii::$app->request->getHostInfo();?>';
        </script>
    </head>
    <body class="page-container-bg-solid page-md">
    <?php echo \common\widgets\modal\AlertMessageWidget::widget([]); ?>
    <div class="div-load"></div>
    <?php $this->beginBody() ?>
    <?php echo $content;?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>