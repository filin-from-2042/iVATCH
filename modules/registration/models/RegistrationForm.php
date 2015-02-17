<?php

namespace app\modules\registration\models;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\authclient;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends User
{

    public $password_repeat;


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('app', 'Username'),
            'password' => \Yii::t('app', 'Password'),
            'password_repeat' => \Yii::t('app', 'Repeat password '),
            'email' => \Yii::t('app', 'Email'),
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username',  'email'], 'unique'],
            [['username', 'password', 'password_repeat', 'email'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 12],
            ['email','email'],
            // built-in "compare" validator
            ['password_repeat', 'compare', 'compareAttribute' => 'password' ],
        ];
    }

}
