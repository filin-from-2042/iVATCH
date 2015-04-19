<?php

namespace app\modules\registration\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class SocialLogin extends Model
{
    public $login_type;
    public $login_id;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login_type', 'login_id'], 'required'],
        ];
    }



    /**
     * Logs in a user using the provided login type and id.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user  = $this->getUser();
            if ($user)
                return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
            return false;
        } else {
            return false;
        }
    }




    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByNetwork($this->login_id,$this->login_type);
        }

        return $this->_user;
    }
}
