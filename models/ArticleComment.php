<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/15
 * Time: 0:11
 */

namespace app\models;


class ArticleComment extends \app\models\table\ArticleComment
{

    public function scenarioFields()
    {
        return [
            'list'=>[
                'id',
            ]
        ];
    }

}