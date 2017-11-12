
<?php
use \app\models\ArticleInfo;
?>


<div class="table-responsive">
    <table class="table table-bordered margin-top-5">
        <thead>
        <tr>
            <th>发布人</th>
            <th>文章类别</th>
            <th>文章标题</th>
            <th>作者</th>
            <th>审核状态</th>
            <th>阅读数</th>
            <th>评论数</th>
            <th>创建时间</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if (is_array($data)) {
            foreach ($data as $item) {
                ?>
                <tr>
                    <td><?php echo $item->nickname;?></td>
                    <td><?php echo $item->cateTitle;?></td>
                    <td><?php echo $item->title;?></td>
                    <td><?php echo $item->author;?></td>
                    <td><?php echo ArticleInfo::$statusDesc[$item->status];?></td>
                    <td><?php echo $item->look_num;?></td>
                    <td><?php echo $item->comment_num;?></td>
                    <td><?php echo $item->create_time;?></td>
                    <td>
                        <?php
                        echo \common\widgets\common\OperateWidget::widget([
                            'updateParams'=>[
                                'title'=>'信息更新',
                                'url'=>'forum/article-update',
                                'params'=>['id'=>$item->id]
                            ],
                            'lookParams'=>[
                                'title'=>'详情预览',
                                'url'=>'forum/article-update',
                                'params'=>['id'=>$item->id,'look'=>true]
                            ],
                            'delParams'=>[
                                'url'=>'forum/article-del',
                                'params'=>[
                                    'id'=>$item->id,
                                    'type'=>\app\services\HomePageService::APPOINTMENT_TYPE_FOR_BRIDGE_LOAN
                                ]
                            ]
                        ])
                        ?>
                    </td>
                </tr>
                <?php
            }
        } ?>
        </tbody>
    </table>
    <div class="" style="float: right;">
        <?php echo \yii\widgets\LinkPager::widget(['pagination' => $pages]); ?>
    </div>
</div>