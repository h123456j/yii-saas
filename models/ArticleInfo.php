<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/14
 * Time: 12:28
 */

namespace app\models;


use app\component\model\Page;
use yii\helpers\VarDumper;

class ArticleInfo extends \app\models\table\ArticleInfo
{

    const TYPE_OF_NEW = 'new';//最新文章
    const TYPE_OF_HOT = 'hot';//精选文章

    const STATUS_FOR_NOT_AUDIT=1;//未审核

    public static $statusDesc=[
        '1'=>'审核中',
        '2'=>'通过',
        '3'=>'不通过'
    ];

    private $cateTitle;//类别名称
    public $nickname;//用户昵称


    public function scenarioFields()
    {
        return [
            'list' => [
                'id' => 'id',
                'cate' => 'cate_code',
                'cateTitle',
                'logo',
                'title' => 'title',
                'author',
                'createTime' => 'create_time'
            ],
            'info' => [
                'id',
                'title',
                'author',
                'createTime' => 'create_time',
                'content',
                'lookNum' => 'look_num',
                'commentNum' => 'comment_num'
            ]
        ];
    }

    /**
     * 分页获取文章数据
     * @param Page $pager
     * @param null $cate
     * @param null $scenario
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getArticleList(Page $pager, $cate = null, $type = null, $scenario = null)
    {
        $query = self::find()
            ->select('ai.*,ac.title as cateTitle')
            ->from(self::getFullName('article_info ai'))
            ->leftJoin(self::getFullName('article_cate ac'), 'ai.cate_code=ac.cate_code');
        if (!empty($cate))
            $query->where(['cate_code' => $cate]);

        switch ($type) {
            case self::TYPE_OF_NEW:
                $query->orderBy(['create_time' => SORT_DESC]);
                break;
            case self::TYPE_OF_HOT:
                $query->orderBy(['look_num' => SORT_DESC, 'comment_num' => SORT_DESC]);
                break;
            default:
                $query->orderBy(['update_time' => SORT_DESC]);
                break;
        }

        $pager->setCount($query->count());
        $data = $query->offset($pager->getOffset())
            ->limit($pager->getLimit())->all();

        if (empty($data) || is_null($scenario))
            return $data;

        foreach ($data as $item) {
            $item->setScenario($scenario);
        }
        return $data;
    }

    public static function getList(Page $pager, $condition = [], $orderBy = [])
    {
        $query = self::find()
            ->select('ai.*,ac.title as cateTitle,ui.nickname')
            ->from(self::getFullName('article_info ai'))
            ->leftJoin(self::getFullName('article_cate ac'), 'ai.cate_code=ac.cate_code')
            ->leftJoin(self::getFullName('user_info ui'), 'ai.uid=ui.uid');
        if (empty($orderBy)) {
            $query->orderBy(['create_time' => SORT_DESC]);
        } else {

        }
        $pager->setCount($query->count());
        return $query->offset($pager->getOffset())
            ->limit($pager->getLimit())
            ->all();
    }

    /**
     * @return mixed
     */
    public function getCateTitle()
    {
        return $this->cateTitle;
    }

    /**
     * @param mixed $cateTitle
     */
    public function setCateTitle($cateTitle)
    {
        $this->cateTitle = $cateTitle;
    }


}