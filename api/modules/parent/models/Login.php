<?php

namespace api\modules\client\models;

use common\models\Client;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Login extends Model
{
    public $mobile;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['mobile', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
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

            if (!empty($user->password_hash) && Yii::$app->getSecurity()->validatePassword($this->password, $user->password_hash)) {
                return true;
            } else {
                $this->addError($attribute, 'Incorrect mobile or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {

        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser()/*, $this->rememberMe ? 3600 * 24 * 30 : 0*/);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return Client|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Client::findByMobile($this->mobile);
        }

        return $this->_user;
    }
}
