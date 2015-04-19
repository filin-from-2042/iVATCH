<?php
/* @var $this yii\web\View */
/* @var $searchModel app\modules\channels\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use app\modules\channels\ChannelsAsset;
use app\widgets;
use webroot\widgets\watching\WatchingPlayer;

ChannelsAsset::register($this);


$this->title = Yii::t('app', 'Channels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channels-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Join', [
		'modelClass' => 'Channels',
	]), ['create'], ['class' => 'btn btn-success','id'=>'join']) ?>
    </p>

    <?=WatchingPlayer::widget()?>

</div>
