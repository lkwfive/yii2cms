<?php

namespace backend\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use Yii;
use backend\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $username = 'admin';
    public $oldpassword;
    public $password;
    public $cpassword;

    private $_user;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'oldpassword', 'password', 'cpassword'], 'required'],
            ['cpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"密码不一致" ],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'oldpassword' => '原密码',
            'password' => '新密码',
            'cpassword' => '确认新密码',
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
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        // $user->removePasswordResetToken();
        // $user->generateAuthKey();

        return $user->save(false);
    }
}
