<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $UserName;
    public $UserPwd;
    public $rememberMe = true; //自动登录，记录用户名
    private $_user = false;
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // UserName and password are both required
            [['UserName', 'UserName'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['UserPwd', 'validatePassword'],
        ];
    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

        //if (!$this->hasErrors()) {
            $user = $this->getUser();// 调用当前模型的getUser方法获取用户
            if (!$user || !$user->validatePassword($this->UserPwd)) {
                $this->addError($attribute, '用户名或密码错误。');
            }
        //}
    }

    /**
     * 根据用户名获取用户的认证信息
     * Logs in a user using the provided UserName and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            //$tmp = '用户登录：login'.Yii::$app->getRequest()->getUserIP().'-'.date('Y-m-d H:i:s',time());
            //file_put_contents('D:/log/swz.txt', print_r($tmp, true), FILE_APPEND);
            //$abc = $this->rememberMe ? 3600*24*30 : 111;
            //file_put_contents('D:/log/swz.txt', print_r($abc, true), FILE_APPEND);
            //file_put_contents('D:/log/swz.txt', "\r\n", FILE_APPEND);
            //这是User类中的方法，第一个参数必须是IdentityInterface的实例。第二个参数就是你的cookie存活时间3600*24*30
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
            //rememberMe是“是否记住我”的选项值为bool型
        }
        return false;
    }

    /**
     * Finds user by [[UserName]]
     *
     * @return User|null
     */
    public function getUser()  //取使用者所有信息
    {
        if ($this->_user === false) {
            $this->_user = User::findByUserName($this->UserName);
        }

        return $this->_user;
    }
}
