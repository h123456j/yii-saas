<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;

\app\assets\common\IeAsset::register($this);
\frontend\assets\AppAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?php echo $this->title;?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="网站描述" name="description" />
        <?php $this->head() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <div style="width: 100%;height: 100px;background-color: #444D58;"></div>
    <body class="page-container-bg-solid page-md">
    <?php $this->beginBody() ?>
        <div class="page-container">
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="container">
                        <?=$content?>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->beginContent('@app/views/layouts/frontend/public/footer.php') ?>
        <?php $this->endContent() ?>
    <?php $this->endBody() ?>
    </body>

</html>
<?php $this->endPage() ?>