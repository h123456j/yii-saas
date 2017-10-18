<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 17:46
 */

namespace app\models;


use app\component\model\Page;

class Message extends \app\models\table\Message
{


    const TYPE_FOR_COMMON = 1;
    const TYPE_FOR_ARTICLE = 2;
    const TYPE_FOR_APPOINTMENT = 3;
    const TYPE_FOR_ESTATE_AUDIT = 4;//物业审核

    public static $typeDesc = [1 => '普通消息', 2 => '文章消息', 3 => '预约反馈', 4 => '物业审核'];

    public function scenarioFields()
    {
        return [
            'list' => [
                'id',
                'title',
                'createTime' => 'create_time',
                'type',
                'typeDesc' => function () {
                    return self::$typeDesc[$this->type];
                },
                'status'
            ],
            'info' => [
                'id',
                'title',
                'createTime' => 'create_time',
                'content'
            ]
        ];
    }

    public static function getMessageList($uid, Page $pager, $cate = null, $scenario = null)
    {
        $query = Message::find()
            ->select('*')
            ->where(['uid' => $uid])
            ->orderBy(['create_time' => SORT_DESC]);

        if (!empty($cate)) {
            if (is_array($cate)) {
                $query->andWhere(['in', 'type', $cate]);
            } else {
                $query->andWhere(['type' => $cate]);
            }
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

}