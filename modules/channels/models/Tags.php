<?php

namespace app\modules\channels\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $tag_name
 *
 * @property Channels2tags[] $channels2tags
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tag_name'], 'required'],
            [['tag_name'], 'trim'],
            [['tag_name'], 'unique'],
            [['tag_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tag_name' => 'Tag Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels2tags()
    {
        return $this->hasMany(Channels2tags::className(), ['tag_id' => 'id']);
    }

    public function getAllTags()
    {
        return $this->getAllTags();
    }
}
