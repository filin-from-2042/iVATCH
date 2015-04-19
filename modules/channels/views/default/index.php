<?php

use yii\helpers\Html;
use app\modules\channels\widgets\channelsList\ChannelsList;
use app\modules\channels\ChannelsAsset;

ChannelsAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\channels\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Channels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channels-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= ChannelsList::widget(['order'=>'title','direction' => 'ASC'])?>
</div>
