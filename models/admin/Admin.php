<?php

namespace backend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\helpers\VarDumper;
use yii\web\IdentityInterface;

/**
 * 实现User组件中的身份识别类 参见 yii\web\user
 * This is the model class for table "{{%admin}}".
 *
 * @property string $uid
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $mobile
 * @property string $reg_time
 * @property string $reg_ip
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property string $update_time
 * @property integer $status
 */
class Admin extends \app\models\table\Admin implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const SYSTEM_GROUP_NAME = 'system';
    const SCENARIO_FOR_ADD='add';
    const SCENARIO_FOR_EDIT='edit';

    public $groupName;
    public $tempPassword;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['username','email'], 'required', 'message' => '该字段不能为空','on'=>self::SCENARIO_FOR_ADD],
//            [['password'],'required','message'=>'该字段不能为空','on'=>self::SCENARIO_FOR_ADD],
//            [['username'], 'string', 'max' => 16, 'message' => '长度超过限制'],
//            [['email'], 'string', 'max' => 32, 'message' => '长度超过限制'],
//            [['mobile'], 'string', 'max' => 11, 'message' => '长度超过限制'],
//            [['username'], 'unique', 'message' => '用户名已存在'],
        ];
    }

    /**
     * 根据UID获取账号信息
     */
    public static function findIdentity($uid)
    {
        return static::find()
            ->select('au.*,ag.name groupName')
            ->from('yii_admin_user au')
            ->leftJoin('yii_admin_user_group ag', 'au.group_id=ag.group_id')
            ->where(['au.uid' => $uid, 'au.status' => self::STATUS_ACTIVE, 'ag.status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * 根据用户名获取账号信息
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->select('au.*,ag.name groupName')
            ->from('yii_admin_user au')
            ->leftJoin('yii_admin_user_group ag', 'au.group_id=ag.group_id')
            ->where(['au.username' => $username, 'au.status' => self::STATUS_ACTIVE, 'ag.status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * 分页获取管理员列表
     * @param $pager
     * @return mixed
     */
    public static function getUserList($pager)
    {
        $query = static::find()
            ->select('au.*,ag.name groupName')
            ->from('yii_admin_user au')
            ->leftJoin('yii_admin_user_group ag', 'au.group_id=ag.group_id')
            ->where(['au.status' => self::STATUS_ACTIVE, 'ag.status' => self::STATUS_ACTIVE])
            ->offset($pager->getOffset())
            ->limit($pager->getLimit());
        $pager->setCount($query->count());
        return $query->all();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token))
            return null;

        return static::find()
            ->select('au.*,ag.name groupName')
            ->from('yii_admin_user au')
            ->leftJoin('yii_admin_user_group ag', 'au.group_id=ag.group_id')
            ->where(['au.password' => $token, 'au.status' => self::STATUS_ACTIVE, 'ag.status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
            return false;

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->salt;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 验证密码
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * 设置加密后的密码
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * 设置密码干扰码
     */
    public function generateAuthKey()
    {
        $this->salt = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password = null;
    }

}
