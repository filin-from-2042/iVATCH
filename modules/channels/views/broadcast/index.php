<?php

use yii\helpers\Html;
use app\modules\channels\ChannelsAsset;
use app\modules\channels\ChannelsBroadcastAsset;

ChannelsAsset::register($this);
ChannelsBroadcastAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\modules\channels\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Channels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channels-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create', [
    'modelClass' => 'Channels',
]), ['create'], ['class' => 'btn btn-success','id'=>'create']) ?>
    </p>

    <video autoplay></video>
    <video id="localVideo" src=""></video>
    <video id="remoteVideo" src=""></video>
</div>
