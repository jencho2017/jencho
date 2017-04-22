<?php
namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
//            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
          'username' =>'用户名 :',
          'password' => '密码 :',
          'rememberMe' => '记住我 '
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
//    public function validatePassword($attribute, $params)
//    {
//        if (!$this->hasErrors()) {
//            $user = $this->getUser();
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }
//        }
//    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $member = Member::findOne(['username'=>$this->username]);
            if($member){
                if(Yii::$app->security->validatePassword($this->password,$member->password_hash)){
                    Yii::$app->user->login($member,$this->rememberMe ? 3600*7*24 :0);
                    return true;
                }else{
                    $this->addError('password','密码不正确');
                }
            }else{
                $this->addError('username','用户名不存在');
            }
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
//    protected function getUser()
//    {
//        if ($this->_user === null) {
//            $this->_user = Member::findByUsername($this->username);
//        }
//
//        return $this->_user;
//    }
}
