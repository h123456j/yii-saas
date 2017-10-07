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