<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord  implements IdentityInterface
{
    public static function tableName()
    {
        return 'sys_user';
    }

    public static function findIdentity($id)
    {
        //print_r($id);exit;
        /*return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
        $sql = "select * from sys_user where UserName='$id'";
        $user = Yii::$app->db->createCommand($sql)->queryOne();
            */
        //$tmp = '用户认证：findIdentity'.Yii::$app->getRequest()->getUserIP().'-'.$id.'-'.date('Y-m-d H:i:s',time());
        //file_put_contents('D:/log/swz.txt', print_r($tmp, true), FILE_APPEND);
        //file_put_contents('D:/log/swz.txt', "\r\n", FILE_APPEND);
        //return static::findOne($id);
        $sql = "select * from sys_user where id='$id'";
        $user = Yii::$app->db->createCommand($sql)->queryOne();
        if($user){
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
        /*foreach (self::$users as $user) {
            if ($user['AccessToken'] === $token) {
                return new static($user);
            }
        }
        return null;*/
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUserName($UserName)
    {
        /*$user = User::find()
            ->where(['userName' => $username])
            //->asArray()
            ->one();*/
        $sql = "select * from sys_user where UserName='$UserName'";
        $user = Yii::$app->db->createCommand($sql)->queryOne();
        if($user){
            return new static($user);
        }
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    /*取角色Id*/
    public function getRoleId()
    {
        return $this->RoleID;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->AuthKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->AuthKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->UserPwd === md5($password);
    }
}