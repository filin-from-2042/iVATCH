<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 19.04.15
 * Time: 11:46
 */

namespace app\modules\channels\controllers;

use app\modules\channels\models\Channels;
use app\modules\channels\models\Channels2tags;
use app\modules\channels\widgets\channelsTags\ChannelsTags;
use yii;
use yii\web\Controller;
use app\modules\channels\widgets\channelsList\ChannelsList;
use app\modules\channels\models\Tags;
use yii\imagine\Image;

class AjaxController extends Controller
{
    public function actionFilter()
    {
        $aPost = Yii::$app->request->post();
        if (!Yii::$app->request->isAjax){ return false;}

        $cOrder = ( isset($aPost['order']) && !empty($aPost['order']) ) ? $aPost['order'] : '';
        $cDirection = ( isset($aPost['direction']) && !empty($aPost['direction']) ) ? $aPost['direction'] : '';
        $bBroadcastingOnly = ( isset($aPost['broadcasting']) && !empty($aPost['broadcasting']) ) ? $aPost['broadcasting'] : '';
        $cExistCont = ( isset($aPost['count']) && !empty($aPost['count']) ) ? $aPost['count'] : '';

        $oChannelList = new ChannelsList();
        $cContent = $oChannelList->getFiltering($cOrder,$cDirection,$bBroadcastingOnly);

        return json_encode(array('content'=>$cContent));
    }

    public function actionSegment()
    {
        $aPost = Yii::$app->request->post();
        if (!Yii::$app->request->isAjax){ return false;}

        $cOrder = ( isset($aPost['order']) && !empty($aPost['order']) ) ? $aPost['order'] : '';
        $cDirection = ( isset($aPost['direction']) && !empty($aPost['direction']) ) ? $aPost['direction'] : '';
        $bBroadcastingOnly = ( isset($aPost['broadcasting']) && !empty($aPost['broadcasting']) ) ? $aPost['broadcasting'] : '';
        $cExistCont = ( isset($aPost['count']) && !empty($aPost['count']) ) ? $aPost['count'] : '';

        $oChannelList = new ChannelsList();
        $cContent = $oChannelList->getSegment($cOrder,$cDirection,$bBroadcastingOnly,$cExistCont);

        return json_encode(array('content'=>$cContent));
    }

    public function actionCreate()
    {
        if (!Yii::$app->request->isAjax){ return false;}
        $aPost = Yii::$app->request->post();
        if(!$aPost["channel_tags"]) return json_encode(array('status'=>'error','message'=>array('Необходимо указать хотя бы один тег!')));

        $channelsModel = new Channels();
        $channelsModel->load($aPost);
        $channelsModel->user_id = Yii::$app->user->identity->id;

        $file = yii\web\UploadedFile::getInstanceByName('Channels[image]');
        if($file) $channelsModel->image = $file;

        // сохранение канала
        if($channelsModel->validate()) $channelsModel->save();
        else
        {
            $messages = array();
            foreach($channelsModel->errors as $field => $text)
            {
                $messages[] = 'Ошибка: '.$text[0];
            }
            return  json_encode(array('status'=>'error','message'=>$messages));
        }

        $aTags = explode(",",$aPost["channel_tags"]);

        // сохранение тегов канала
        foreach($aTags as $tag)
        {
            $tagModel = Tags::find()->where(["tag_name"=>$tag])->one();
            // добавление новых тегов
            if(!$tagModel)
            {
                $tagModel = new Tags();
                $tagModel->tag_name = $tag;
                if($tagModel->validate())$tagModel->save();
                else
                {
                    $messages = array();
                    foreach($tagModel->errors as $field => $text)
                    {
                        $messages[] = 'Ошибка в поле "'.$tagModel->getAttributeLabel($field).'": '.$text[0];
                    }
                    return  json_encode(array('status'=>'error','message'=>$messages));
                }
            }
            // соответсвие канал-тег
            $c2tModel = new Channels2tags();
            $c2tModel->channel_id = $channelsModel->id;
            $c2tModel->tag_id = $tagModel->id;
            if($c2tModel->validate()) $c2tModel->save();
            else
            {
                $messages = array();
                foreach($c2tModel->errors as $field => $text)
                {
                    $messages[] = 'Ошибка в поле "'.$c2tModel->getAttributeLabel($field).'": '.$text[0];
                }
                return  json_encode(array('status'=>'error','message'=>$messages));
            }
        }

        return  json_encode(array('status'=>'ok','message'=>array("Канал успешно создан")));

    }

    public function actionTags()
    {
        $aPost = Yii::$app->request->post();
        $aGet = Yii::$app->request->get();
        $tagPart = $aGet["tag-name"];
        if (!Yii::$app->request->isAjax){ return false;}
        $aTags = array();
        $query = Tags::find();

        $tags = $query->andFilterWhere(['like', 'tag_name', $tagPart])->all();

        foreach($tags as $tag)
        {
            $aTags[] = array('name'=>$tag['tag_name']);
        }

        return json_encode($aTags);
    }
}