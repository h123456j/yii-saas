<?php
/**
 * Created by PhpStorm.
 * User: huangj06
 * Date: 2017/10/10
 * Time: 10:16
 */

return [
    'user' => [
        'identityClass' => 'backend\models\Admin',
        'enableAutoLogin' => false,
        'loginUrl' => array('admin/login'),
    ],
];