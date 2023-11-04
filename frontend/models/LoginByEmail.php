<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

use common\models\User;
use common\models\AccessTokens;

/*
 * Login by email
 */
class LoginByEmail extends Model
{
    public $email;
    public $password;
    public $accessToken;

    private $_user;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }
        }
    }

    public function login()
    {
        if (!$this->validate()) {
            return false;
        }

        if (!Yii::$app->user->login($this->getUser())) {
            $this->addError('login','Failed to log in!');
            $this->addErrors($this->_user->getErrors());
            return false;
        }

        // TODO:: Сгенерировать токен и вернуть обратно
        $this->accessToken = AccessTokens::generateAccessToken($this->_user->getId());

        return true;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}