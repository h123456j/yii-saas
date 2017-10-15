<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 0:11
 */

namespace app\models;


use app\component\model\Page;

class ArticleComment extends \app\models\table\ArticleComment
{

    //附加字段
    public $nickname;
    public $headPhoto;

    public function scenarioFields()
    {
        return [
            'list'=>[
                'id',
                'pid',
                'nickname',
                'headPhoto',
                'content',
                'createTime'=>'create_time'
            ]
        ];
    }

    public static function getCommentList($id,Page $pager,$scenario=null)
    {
        $query=self::find()
            ->select('ac.*,ui.nickname,ui.head_photo headPhoto')
            ->from(self::getFullName("article_comment ac"))
            ->leftJoin(self::getFullName('user_info ui'),'ac.uid=ui.uid')
            ->where(['ac.article_id'=>$id])
            ->orderBy(['ac.create_time'=>SORT_DESC])
            ->offset($pager->getOffset())
            ->limit($pager->getLimit());
        $pager->setCount($query->count());
        $data=$query->all();
        if(empty($data) || is_null($scenario))
            return $data;

        foreach($data as $item){
            $item->setScenario($scenario);
        }

        return $data;
    }

}