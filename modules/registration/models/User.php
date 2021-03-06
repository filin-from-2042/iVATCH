<?php

namespace app\modules\registration\models;

use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;
use app\modules\channels\models\Channels;

class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','email'], 'unique'],
            [['username','email','password'], 'required'],
            [['verified', 'banned', 'send_to_email', 'send_newsletter'], 'boolean'],
            [['login_type', 'image_path', 'background_path'], 'string'],
            ['login_id', 'integer'],
            [['last_visit_timestamp', 'registration_timestamp'], 'safe'],
            [['wallet'], 'number'],
            [['username', 'password', 'email', 'background_path'], 'string', 'max' => 100],
            [['registration_ip', 'last_logged_ip', 'real_surname', 'real_name'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 2],
//            ['password_repeat', 'compare', 'compareAttribute' => 'password'  ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => \Yii::t('app', 'ID'),
            'username' => \Yii::t('app', 'Username'),
            'password' => \Yii::t('app', 'Password'),
            'email' => \Yii::t('app', 'Email'),
            'verified' => \Yii::t('app', 'Verified'),
            'banned' => \Yii::t('app', 'Banned'),
            'login_type' => \Yii::t('app', 'Login Type'),
            'login_id' => \Yii::t('app', 'Login ID'),
            'send_to_email' => \Yii::t('app', 'Send To Email'),
            'send_newsletter' => \Yii::t('app', 'Send Newsletter'),
            'last_visit_timestamp' => \Yii::t('app', 'Last Visit Timestamp'),
            'registration_timestamp' => \Yii::t('app', 'Registration Timestamp'),
            'registration_ip' => \Yii::t('app', 'Registration Ip'),
            'last_logged_ip' => \Yii::t('app', 'Last Logged Ip'),
            'wallet' => \Yii::t('app', 'Wallet'),
            'currency' => \Yii::t('app', 'Currency'),
            'image_path' => \Yii::t('app', 'Image Path'),
            'background_path' => \Yii::t('app', 'Background Path'),
            'real_name' => \Yii::t('app', 'Real name'),
            'real_surname' => \Yii::t('app', 'Real surname'),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by social network
     *
     * @param  string      $login_id
     * @param  string      $login_type
     * @return static|null
     */
    public static function findByNetwork($login_id, $login_type)
    {
        return static::findOne(['login_id' => $login_id, 'login_type'=>$login_type]);
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
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === ($password);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channels::className(), ['user_id' => 'id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['to_user' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Options::className(), ['owner id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers2channels()
    {
        return $this->hasMany(Users2channels::className(), ['user_id' => 'id']);
    }
}
