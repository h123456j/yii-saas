<?php

/** @var $this \yii\web\View */
/** @var $content string */
/** @var $context \yii\web\Controller */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\models\Menu;

AppAsset::register($this);
$menuTree = Menu::getMenus(); // 获取后台栏目
$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title><?= Html::encode($this->title) ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta content="" name="description"/>
        <meta content="" name="author"/>
        <?php $this->head() ?>
        <link rel="shortcut icon" href="<?= Yii::getAlias('@web/favicon.ico') ?>"/>
        <script language="JavaScript">
            var BaseUrl = '<?echo  Yii::$app->request->getHostInfo();?>';
        </script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <?php
    echo \common\widgets\modal\AlertMessageWidget::widget([]);
    echo \common\widgets\modal\ContentModalWidget::widget([]);
    ?>
    <div class="div-load"></div>
    <?php $this->beginBody() ?>
    <div class="page-header navbar navbar-fixed-top">
        <div class="page-header-inner ">
            <div class="page-logo">
                <a href="<?= Yii::getAlias('@web') ?>">
                    <img src="<?= Yii::getAlias('@web/static/images/logo.png') ?>" alt="logo" class="logo-default"/>
                </a>

                <div class="menu-toggler sidebar-toggler">
                    <span></span>
                </div>
            </div>
            <?php echo $this->render('@app/views/layouts/admin/menu.php', ['data' => $menuTree['main']]); ?>
            <form class="search-form" action="" method="GET">
                <div class="input-group">
                    <input name="s" type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                </div>
            </form>
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse"
               data-target=".navbar-collapse">
                <span></span>
            </a>

            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <img alt="" class="img-circle"
                                 src="<?= Yii::getAlias('@web/static/images/default-avatar.jpg') ?>"/>
                            <span class="username username-hide-on-mobile"
                                  style="font-size: 16px;color: #ffffff;"> <?= Yii::$app->user->identity->username ?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li><a href="<?= Url::toRoute('login/logout') ?>"><i class="icon-key"></i> 注销 </a></li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-quick-sidebar-toggler">
                        <a href="<?= Url::toRoute('login/logout') ?>" class="dropdown-toggle">
                            <i class="icon-logout"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="page-container">
        <div class="page-sidebar-wrapper">
            <div class="page-sidebar navbar-collapse collapse">
                <?php echo $this->render('@app/views/layouts/admin/menu-sub.php', ['data' => $menuTree['_child']]); ?>
            </div>
        </div>
        <div class="page-content-wrapper">
            <div id="top-message" class="fixed alert alert-error alert_left" style="display: none;">
                <button id="btn-message-close" class="close" style="margin-top:6px;">&times;</button>
                <div class="alert-content">提示信息</div>
            </div>
            <!-- BEGIN CONTENT BODY -->
            <div class="page-content">
                <?php $this->beginContent('@app/views/layouts/admin/setting.php') ?>
                <?php $this->endContent() ?>
                <h3 class="page-title">
                    <?= Html::encode($this->title) ?>
                    <small><?= Html::encode(isset($this->params['title_sub']) ? $this->params['title_sub'] : '') ?></small>
                </h3>
                <div class="row">
                    <div class="col-md-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-footer">
        <div class="page-footer-inner">
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <?php \backend\assets\LayoutAsset::register($this); ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>