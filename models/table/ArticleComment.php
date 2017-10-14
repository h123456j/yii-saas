<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 0:10
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class ArticleComment extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%article_comment}}';
    }

}