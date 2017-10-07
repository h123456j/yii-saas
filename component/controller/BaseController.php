<?php
/**
 * Created by PhpStorm.
 * User: huang
 * Date: 2017/10/3
 * Time: 10:44
 */

namespace app\component\controller;


use app\component\filter\Signature;
use yii\web\Controller;

class BaseController extends Controller
{

    public function behaviors()
    {
        return [
//            'sign'=>[
//                'class'=>Signature::className()
//            ]
        ];
    }

}