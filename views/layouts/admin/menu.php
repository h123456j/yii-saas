<div class="hor-menu hidden-sm hidden-xs">
    <ul class="nav navbar-nav">
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $menu):?>
                <li class="classic-menu-dropdown <?php if (isset($menu['class'])) {
                    echo 'active';
                } ?>">
                    <a href="<?php echo empty($menu['url'])?'':\app\component\helpers\Util::getUrl($menu['url']);?>">
                        <?= $menu['title'] ?>
                        <?php if (isset($menu['class'])) {
                            echo '<span class="selected"></span>';
                        } ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
