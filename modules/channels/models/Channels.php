<?php

namespace app\modules\channels\models;

use Yii;
use app\models\User;
/**
 * This is the model class for table "channels".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $category_id
 * @property string $image_path
 * @property integer $tariff_id
 * @property string $tariff_start
 * @property string $tariff_end
 * @property integer $subscribers_count
 * @property string $subscribe_plan
 * @property double $subscription_cost
 *
 * @property Users $user
 * @property Categories $category
 * @property Tariffs $tariff
 * @property Channels2tags[] $channels2tags
 * @property Events[] $events
 * @property Options[] $options
 * @property Users2channels[] $users2channels
 */
class Channels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'description'], 'required'],
            [['user_id', 'category_id', 'tariff_id', 'subscribers_count'], 'integer'],
            [['tariff_start', 'tariff_end'], 'safe'],
            [['subscribe_plan', 'image_path'], 'string'],
            [['subscription_cost'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'category_id' => Yii::t('app', 'Category ID'),
            'image_path' => Yii::t('app', 'Image path'),
            'tariff_id' => Yii::t('app', 'Tariff ID'),
            'tariff_start' => Yii::t('app', 'Tariff Start'),
            'tariff_end' => Yii::t('app', 'Tariff End'),
            'subscribers_count' => Yii::t('app', 'Subscribers Count'),
            'subscribe_plan' => Yii::t('app', 'Subscribe Plan'),
            'subscription_cost' => Yii::t('app', 'Subscription Cost'),
        ];
    }

    /**
     * Finds channel by title
     *
     * @param  string      $title
     * @return static|null
     */
    public static function findByUsername($title)
    {
        return static::findOne(['title' => $title]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTariff()
    {
        return $this->hasOne(Tariffs::className(), ['id' => 'tariff_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels2tags()
    {
        return $this->hasMany(Channels2tags::className(), ['channel_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Events::className(), ['channel_id' => 'id']);
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
        return $this->hasMany(Users2channels::className(), ['channel_id' => 'id']);
    }
}
