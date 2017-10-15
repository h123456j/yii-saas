<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/14
 * Time: 12:25
 */

namespace app\services;


use app\component\session\SessionContainer;
use app\models\ArticleComment;
use app\models\ArticleInfo;
use app\models\UserInfo;
use app\services\base\BaseService;
use yii\db\Expression;
use yii\helpers\VarDumper;

class ArticleService extends BaseService
{

    public function getArticleList($cate,$type,$pager)
    {
        $data=ArticleInfo::getArticleList($pager,$cate,$type,'list');
        return [
            'page'=>$pager,
            'items'=>$data
        ];
    }

    /**
     * 文章发布
     * @param $cate
     * @param $data
     * @return bool
     */
    public function articlePublish($cate,$data)
    {
        $articleInfo=new ArticleInfo();
        $uid=SessionContainer::getUid();
        $userInfo=UserInfo::findOne(['uid'=>$uid]);
        if(!empty($userInfo))
            $articleInfo->author=$userInfo->nickname;
        $articleInfo->uid=$uid;
        $articleInfo->cate_code=$cate;
        $articleInfo->title=$data['title'];
        $articleInfo->logo=$data['logo'];
        $articleInfo->content=$data['content'];
        $articleInfo->create_time=$articleInfo->update_time=date('Y-m-d H:i:s');
        return $articleInfo->save();
    }

    /**
     * 获取文章详情
     * @param $id
     * @param string $scenario
     * @return static
     */
    public function getArticleInfo($id,$scenario='info')
    {
        $data=ArticleInfo::findOne(['id'=>$id,'status'=>ArticleInfo::STATUS_IS_AUDIT]);
        if(!empty($data)){
            $data->setScenario($scenario);
            ArticleInfo::updateAll(['look_num'=>new Expression('look_num+1')],['id'=>$id]);
        }
        return $data;
    }

    public function getArticleCommentList($id,$pager,$scenario='list')
    {
        $data=ArticleComment::getCommentList($id,$pager,$scenario);
        return [
            'page'=>$pager,
            'items'=>$data
        ];
    }

    /**
     *  文章评论
     * @param $id
     * @param $pid
     * @param $content
     * @return bool
     */
    public function articleComment($id,$pid,$content)
    {
        $comment=new ArticleComment();
        $comment->article_id=$id;
        $comment->pid=$pid;
        $comment->uid=SessionContainer::getUid();
        $comment->content=$content;
        $comment->create_time=$comment->update_time=date('Y-m-d H:i:s');
        if($result=$comment->save())
            ArticleInfo::updateAll(['comment_num'=>new Expression('comment_num+1')],['id'=>$id]);
        return $result;
    }



}