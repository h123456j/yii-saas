<?php if (!empty($update)) { ?>
    <span data-title="<?php echo $update['title'] ?>" data-url="<?php echo \app\component\helpers\Util::getUrl($update['url'], $update['params']); ?>" style="color: #1465AC;padding: 0 5px;" class="content-modal glyphicon glyphicon-pencil"></span>
<?php }
if (!empty($del)) {?>
    |<span data-url="<?php echo \app\component\helpers\Util::getUrl($del['url']) ?>" data-params='<?php echo json_encode($del['params']);?>' style="color: #FF0000;padding: 0 5px;" class="ajax-del glyphicon glyphicon-trash"></span>
<?php } ?>

