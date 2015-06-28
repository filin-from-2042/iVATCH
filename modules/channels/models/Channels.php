<?php

namespace app\modules\channels\models;

use Yii;
use yii\imagine\Image;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\helpers\FileHelper;
use yii\helpers\Json;
/**
 * This is the model class for table "channels".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $description
 * @property integer $category_id
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
    public $image;
    public $crop_info;
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
            [['user_id', 'title', 'description'], 'required', 'message'=>'поле обязательно для заполнения!'],
            [['user_id', 'title', 'description'], 'trim'],
            [['user_id'], 'unique','message'=>'У пользователя уже существует канал'],
            [['user_id', 'subscribers_count'], 'integer'],
            [['subscribe_plan'], 'string'],
            [['subscription_cost'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            ['crop_info', 'safe']
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
            'title' => "Название канала",
            'description' => "Описание канала",
            'subscribers_count' => Yii::t('app', 'Subscribers Count'),
            'subscribe_plan' => Yii::t('app', 'Subscribe Plan'),
            'subscription_cost' => Yii::t('app', 'Subscription Cost'),
            'image' => "Аватар канала",
        ];
    }

    /**
     * Finds channel by title
     *
     * @param  string      $title
     * @return static|null
     */
    public static function findByTitle($title)
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

    public function afterSave()
    {
        if(!$this->image) return;
        // open image
        $image = Image::getImagine()->open($this->image->tempName);

        // rendering information about crop of ONE option
        $cropInfo = Json::decode($this->crop_info)[0];
        $cropInfo['dw'] = (int)$cropInfo['dw']; //new width image
        $cropInfo['dh'] = (int)$cropInfo['dh']; //new height image
        $cropInfo['x'] = abs($cropInfo['x']); //begin position of frame crop by X
        $cropInfo['y'] = abs($cropInfo['y']); //begin position of frame crop by Y

        // remove old
        $oldImages = FileHelper::findFiles(Yii::getAlias('@app/uploads/channels_logo'), [
            'only' => [
                $this->id . '.*',
            ],
        ]);
        for ($i = 0; $i != count($oldImages); $i++) {
            @unlink($oldImages[$i]);
        }

        //saving thumbnail
        $newSizeThumb = new Box($cropInfo['dw'], $cropInfo['dh']);
        $cropSizeThumb = new Box(200, 200); //frame size of crop
        $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
        $pathThumbImage = Yii::getAlias('@app/uploads/channels_logo/') . '/thumb_' . $this->id . '.' . $this->image->getExtension();

        $image->resize($newSizeThumb)
            ->crop($cropPointThumb, $cropSizeThumb)
            ->save($pathThumbImage, ['quality' => 100]);
    }

}
