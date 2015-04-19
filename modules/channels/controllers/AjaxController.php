<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 19.04.15
 * Time: 11:46
 */

namespace app\modules\channels\controllers;

use yii;
use yii\web\Controller;
use app\modules\channels\widgets\channelsList\ChannelsList;

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
}