<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\modules\channels\ChannelsAsset;
$this->registerJSFile('https://cdn.socket.io/socket.io-1.3.3.js');
ChannelsAsset::register($this);
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
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Channels',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<!--
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'title',
            'description',
            'category_id',
            // 'image_id',
            // 'tariff_id',
            // 'tariff_start',
            // 'tariff_end',
            // 'subscribers_count',
            // 'subscribe_plan',
            // 'subscription_cost',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
-->


    <video autoplay></video>
</div>
