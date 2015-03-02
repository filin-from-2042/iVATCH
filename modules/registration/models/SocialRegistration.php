<?php

namespace app\modules\registration\models;

use app\models\User;
use Yii;
use yii\base\Model;
use yii\authclient;

/**
 * LoginForm is the model behind the login form.
 */
class SocialRegistration extends User
{

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'login_type' => \Yii::t('app', 'Login type'),
            'login_id' => \Yii::t('app', 'Login id'),
        ];
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['login_type', 'login_id'], 'required'],
            [[ 'login_id', 'username'], 'unique'],
        ];
    }

}
