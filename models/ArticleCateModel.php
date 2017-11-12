<?php
/**
 * Created by PhpStorm.
 * User: huang-jiang
 * Date: 2017/11/12
 * Time: 22:12
 */

namespace app\models;


use app\models\table\ArticleCate;

class ArticleCateModel extends ArticleCate
{

    public static function getCateList($index = true)
    {
        $data = self::find()
            ->select('*')
            ->where(['status' => 1])
            ->all();
        if (empty($data) || !$index)
            return $data;

        $list = [];
        foreach ($data as $item) {
            $list[$item['cate_id']] = $item['title'];
        }
        return $list;
    }


}