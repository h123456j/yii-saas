<?php
/**
 * Created by PhpStorm.
 * User: huang_jiang
 * Date: 2017/10/11
 * Time: 16:20
 */

namespace app\component\filter;


use common\error\Error;
use yii\base\ActionFilter;
use yii\helpers\VarDumper;

defined('YII_REQUEST_START_TIME') or define('YII_REQUEST_START_TIME', '');

class ApiSessionFilter extends ActionFilter
{

    public function beforeAction($action)
    {
        return $this->filterSession();
    }

    /**
     * 登录态过滤
     * @return bool
     */
    public function filterSession()
    {
        \Yii::beginProfile('FILTER-SESSION-' . YII_REQUEST_START_TIME);
        $uid = isset($_REQUEST['uid']) ? $_REQUEST['uid'] : null;
        $sid = isset($_REQUEST['sid']) ? $_REQUEST['sid'] : null;
        self::checkSession($uid, $sid);
        \Yii::endProfile('FILTER-SESSION-' . YII_REQUEST_START_TIME);
        return true;
    }

    /**
     * 登录态检查
     * @param $uid
     * @param $sid
     * @param bool $throwError
     * @return bool|null
     */
    private static function checkSession($uid, $sid, $throwError = true)
    {
        if (empty($uid) || empty($sid)) {
            if ($throwError)
                \Yii::$app->response->error(Error::USER_NEED_TO_LOGIN, '请先登录');
            return null;
        }
        $session = \Yii::$app->getSession();
        $userInfo = $session->readSession($uid);
        if (empty($userInfo) || $userInfo->valid_time < time()) {
            $session->destroySession($uid);
            if ($throwError)
                \Yii::$app->response->error(Error::USER_SESSION_INVALID, '登录态失效，请重新登录');
            return null;
        }
        return true;
    }

}