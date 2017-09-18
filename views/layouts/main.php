<?php

/** @var $this \yii\web\View */
/** @var $content string */
/** @var $context \yii\web\Controller */

use yii\helpers\Html;
use yii\helpers\Url;
use backend\assets\AppAsset;
use backend\models\Menu;
AppAsset::register($this); // 注册前端资源
$context = $this->context;
$allMenu = Menu::getMenus($context->module->id,$context->id,$context->action->id); // 获取后台栏目
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title><?= Html::encode($this->title) ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?php $this->head() ?>
        <link rel="shortcut icon" href="<?=Yii::getAlias('@web/favicon.ico')?>" />
        <script language="JavaScript">
            var BaseUrl = '<?=Yii::getAlias('@web')?>';
        </script>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md">
    <?php $this->beginBody() ?>
        <div class="page-header navbar navbar-fixed-top">
            <div class="page-header-inner ">
                <div class="page-logo">
                    <a href="<?=Yii::getAlias('@web')?>">
                        <img src="<?=Yii::getAlias('@web/static/images/logo.png')?>" alt="logo" class="logo-default" /> </a>
                    <div class="menu-toggler sidebar-toggler">
                        <span></span>
                    </div>
                </div>
                <?php echo $this->render('@app/views/layouts/admin/menu.php', ['allMenu'=>$allMenu]); ?>
                <form class="search-form" action="" method="GET">
                    <div class="input-group">
                        <input name="s" type="text" class="form-control" placeholder="Search..." >
                        <span class="input-group-btn">
                            <a href="javascript:;" class="btn submit">
                                <i class="icon-magnifier"></i>
                            </a>
                        </span>
                    </div>
                </form>
                <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
                    <span></span>
                </a>
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <li class="dropdown dropdown-user">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <img alt="" class="img-circle" src="<?=Yii::getAlias('@web/static/images/default-avatar.jpg')?>" />
                                <span class="username username-hide-on-mobile" style="font-size: 16px;color: #ffffff;"> <?=Yii::$app->user->identity->username?> </span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li><a href="<?=Url::toRoute('login/logout')?>"><i class="icon-key"></i> 注销 </a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-quick-sidebar-toggler">
                            <a href="<?=Url::toRoute('login/logout')?>" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="clearfix"> </div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <?php echo $this->render('@app/views/layouts/admin/menu-sub.php', ['allMenu'=>$allMenu]); ?>
                </div>
            </div>
            <div class="page-content-wrapper">
                <!-- 表单操作ajax弹出提示 -->
                <style>
                    .fixed{position: fixed!important;}
                    .alert{color: #c09853;font-weight: bold;border: 1px solid #fbeed5;background-color: #fcf8e3;}
                    #top-alert {display: block;top: 40px;right: 20px;z-index: 9999;margin-top: 20px;padding-top: 12px;padding-bottom: 12px;overflow: hidden;font-size: 16px;}
                    .alert-error {color: white;border-color: #eed3d7;background-color: #FF6666;}
                    .alert-success {color: #468847;background-color: #CCFF99;border-color: #eed3d7;}
                    @media (max-width: 768px) {.alert_left {left:20px; }}
                    @media (min-width: 768px) {.alert_left {left:245px; }}
                </style>
                <div id="top-alert" class="fixed alert alert-error alert_left" style="display: none;">
                    <button class="close" style="margin-top:6px;">&times;</button>
                    <div class="alert-content">这是Ajax弹出内容</div>
                </div>

                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <?php $this->beginContent('@app/views/layouts/admin/setting.php') ?>
                    <?php $this->endContent() ?>
                    <h3 class="page-title">
                        <?= Html::encode($this->title) ?>
                        <small><?= Html::encode(isset($this->params['title_sub'])?$this->params['title_sub']:'') ?></small>
                    </h3>
                    <div class="row">
                        <div class="col-md-12">
                            <?=$content?>
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