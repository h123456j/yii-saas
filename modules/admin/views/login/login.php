
<div class="logo"></div>
<div id="form-body" class="content">
    <?php
    $form = \app\component\widgets\ActiveForm::begin([
        'options' => [
            'role' => 'form',
            'class' => 'form-horizontal ajax-form',
            'enctype' => 'multipart/form-data'
        ]
    ]);
    ?>
    <h3 class="form-title font-green">登&nbsp;&nbsp;&nbsp;录</h3>

    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span> 用户名或密码错误 </span>
    </div>
    <div class="form-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">用户名</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off"
               placeholder="用户名" name="info[username]"/>
    </div>
    <div class="form-group">
        <label class="control-label visible-ie8 visible-ie9">密码</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off"
               placeholder="密码" name="info[password]"/>
    </div>
    <div class="form-actions">
        <label class="rememberme check mt-checkbox mt-checkbox-outline" style="padding-left:25px;">
            <input type="checkbox" name="info[rememberMe]" value="1" checked/>记住我
            <span></span>
        </label>
        <button type="submit" class="btn green pull-right" style="margin-top:-10px;">登&nbsp;&nbsp;录</button>
    </div>
    <div class="create-account"></div>
    <?php $form->end(); ?>
</div>