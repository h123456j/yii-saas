<ul class="page-sidebar-menu  page-header-fixed hidden-sm hidden-xs" data-keep-expanded="false" data-auto-scroll="true"
    data-slide-speed="200" style="padding-top: 20px">
    <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
            <span></span>
        </div>
    </li>

    <?php if (!empty($allMenu['child']) && is_array($allMenu['child'])) {
        foreach ($allMenu['child'] as $menu) {
            if (empty($menu['_child'])) {
                ?>
                <li class="nav-item <?php echo isset($menu['class'])?'active':''?>">
                    <a href="<?= \yii\helpers\Url::toRoute($menu['url']) ?>" nav="<?= $menu['url'] ?>" class="nav-link">
                        <i class="icon-docs"></i>
                        <span class="title"><?= $menu['title'] ?></span>
                    </a>
                </li>
            <?php } else { ?>
                <li class="nav-item ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                        <span class="title"><?= $menu['title'] ?></span>
                        <span class="arrow <?php echo isset($menu['class'])?'open':''; ?>"></span>
                    </a>
                    <ul class="sub-menu" style="<?php echo isset($menu['class'])?'display:block;':''; ?>">
                        <?php if (is_array($menu['_child'])): ?>
                            <?php foreach ($menu['_child'] as $v): ?>
                                <li class="nav-item" style="<?php echo isset($v['class'])?'background-color: #36C6D3;':''; ?>">
                                    <a style="<?php echo isset($v['class'])?'color:#FFFFFF;':'';?>" href="<?= \yii\helpers\Url::toRoute($v['url']) ?>" nav="<?= $v['url'] ?>" class="nav-link ">
                                        <?= $v['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php
            }
        }
    } ?>
</ul>
