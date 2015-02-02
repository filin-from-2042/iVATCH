<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\channels\models\ChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channels-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'image_id') ?>

    <?php // echo $form->field($model, 'tariff_id') ?>

    <?php // echo $form->field($model, 'tariff_start') ?>

    <?php // echo $form->field($model, 'tariff_end') ?>

    <?php // echo $form->field($model, 'subscribers_count') ?>

    <?php // echo $form->field($model, 'subscribe_plan') ?>

    <?php // echo $form->field($model, 'subscription_cost') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
