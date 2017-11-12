<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/12
 * Time: 22:11
 */

namespace app\models\table;


use common\core\BaseActiveRecord;

class ArticleCate extends BaseActiveRecord
{

    public static function tableName()
    {
        return '{{%article_cate}}';
    }

}