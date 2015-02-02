<?php

namespace app\modules\users;
use app\modules\channels\models\Channels;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property boolean $verified
 * @property boolean $banned
 * @property string $login_type
 * @property integer $login_id
 * @property boolean $send_to_email
 * @property boolean $send_newsletter
 * @property string $last_visit_timestamp
 * @property string $registration_timestamp
 * @property string $registration_ip
 * @property string $last_logged_ip
 * @property double $wallet
 * @property string $currency
 * @property integer $image_path
 *
 * @property Channels[] $channels
 * @property Messages[] $messages
 * @property Options[] $options
 * @property Images $image
 * @property Users2channels[] $users2channels
 */
class Users extends \yii\db\ActiveRecord
{
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
            [['username'], 'required'],
            [['verified', 'banned', 'send_to_email', 'send_newsletter'], 'boolean'],
            [['login_type'], 'string'],
            [['login_id', 'image_id'], 'integer'],
            [['last_visit_timestamp', 'registration_timestamp'], 'safe'],
            [['wallet'], 'number'],
            [['username', 'password', 'email'], 'string', 'max' => 100],
            [['registration_ip', 'last_logged_ip'], 'string', 'max' => 20],
            [['currency'], 'string', 'max' => 2]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'email' => Yii::t('app', 'Email'),
            'verified' => Yii::t('app', 'Verified'),
            'banned' => Yii::t('app', 'Banned'),
            'login_type' => Yii::t('app', 'Login Type'),
            'login_id' => Yii::t('app', 'Login ID'),
            'send_to_email' => Yii::t('app', 'Send To Email'),
            'send_newsletter' => Yii::t('app', 'Send Newsletter'),
            'last_visit_timestamp' => Yii::t('app', 'Last Visit Timestamp'),
            'registration_timestamp' => Yii::t('app', 'Registration Timestamp'),
            'registration_ip' => Yii::t('app', 'Registration Ip'),
            'last_logged_ip' => Yii::t('app', 'Last Logged Ip'),
            'wallet' => Yii::t('app', 'Wallet'),
            'currency' => Yii::t('app', 'Currency'),
            'image_path' => Yii::t('app', 'Path to image'),
        ];
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