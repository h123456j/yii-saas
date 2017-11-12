<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/12
 * Time: 21:26
 */

namespace backend\controllers;


use app\component\helpers\Util;
use app\component\model\Page;
use app\models\ArticleInfo;
use app\services\ArticleService;
use yii\data\Pagination;
use yii\helpers\VarDumper;

class ForumController extends BaseController
{

    public function actionIndex()
    {
        $this->setPageTitle('论坛中心');
        return $this->render('/common');
    }

    public function actionArticleList($page = self::DEFAULT_PAGE, $pageSize = self::DEFAULT_PAGE_SIZE)
    {
        $this->setPageTitle('文章列表');
        $pager = new Page($page, $pageSize);
        $data = ArticleService::instance()->getList($pager);
        $pages = new Pagination(['totalCount' => $pager->getCount(), 'pageSize' => $pageSize]);
        return $this->render('article-list', ['data' => $data, 'pages' => $pages]);
    }

    public function actionArticleUpdate($id = null, $look = false)
    {
        $this->layout = self::LAYOUT_TEMPLATE_SIMPLE;
        if (is_null($id)) {
            $articleInfo = new ArticleInfo();
        } else {
            $articleInfo = ArticleService::instance()->getArticleInfo($id, 'default', false);
        }

        if (\Yii::$app->request->getIsPost()) {
            $data = \Yii::$app->request->post('ArticleInfo');
            Util::trim($data);
            $articleInfo->setAttributes($data, false);
            $result = ArticleService::instance()->updateArticleInfo($articleInfo);
            if (is_null($result))
                return self::error();
            return self::success();
        }

        if (empty($articleInfo))
            return Util::systemError();

        return $this->render('article-update', ['data' => $articleInfo, 'look' => $look]);
    }

    public function actionArticleDel()
    {
        $id = \Yii::$app->request->post('id');
        $result = ArticleService::instance()->delArticleInfo($id);
        if (is_null($result))
            return self::error();
        return self::success('删除成功');
    }

    public function actionArticleCommentList()
    {
        $this->setPageTitle('评论列表');
    }

}