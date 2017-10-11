<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/7
 * Time: 17:46
 */

namespace api\controllers;


use app\component\controller\BaseController;

/**
 * Class ForumController
 * @package api\controllers
 * @controller-name 论坛模块
 */
class ForumController extends BaseController
{
    /**
     * @api-name 文章列表
     * @api-method GET
     * @api-url forum/article-list
     * @api-param int $page 页码（默认为1）
     * @api-param int $pageSize 每页数量（默认为15）
     * @api-response{
     * }
     */
    public function actionArticleList()
    {

    }

    /**
     * @api-name 文章发布
     * @api-method POST
     * @api-url forum/article-publish
     * @api-param string $uid 用户id
     * @api-param string $sid 会话id
     * @api-param string $content 文章内容
     * @api-response{
     *      "data":"1",(0-失败 1-成功)
     * }
     */
    public function actionArticlePublish()
    {

    }

    /**
     * @api-name 文章详情
     * @api-method GET
     * @api-url forum/article-info
     * @api-param int $articleId 文章id
     * @api-response{
     * }
     */
    public function actionArticleInfo()
    {

    }

    /**
     * @api-name 文章评论列表
     * @api-method GET
     * @api-url forum/comment-list
     * @api-param int $articleId 文章id
     * @api-param int $page 页码
     * @api-param int $pageSize 每页数量
     * @api-response {
     * }
     */
    public function actionCommentList()
    {

    }

    /**
     * @api-name 文章评论
     * @api-method POST
     * @api-url forum/comment
     * @api-param int $articleId 文章id
     * @api-param int $content 评论内容
     * @api-response {
     * }
     */
    public function actionComment()
    {

    }

}