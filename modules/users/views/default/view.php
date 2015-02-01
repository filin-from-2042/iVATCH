<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\users\UsersAsset;
UsersAsset::register($this);
?>
<div class="Users-default-index">
    <h2>User profile</h2>
    <h1><?=$model['username']?></h1>
    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>


    <div class="container-fluid user-info">
        <div class="row">
            <div class="col-lg-8 col-md-8 cl-sm-6 col-xs-12" id="user-image">
                <?= $image?Html::img($image, ['alt'=>'some', 'class'=>'img-responsive']):'';?>
            </div>
            <div class="col-lg-4 col-md-4 cl-sm-6 col-xs-12" id="user-links">
                <div class="row" id="user-about">
                    <span class="glyphicon glyphicon-user"  aria-hidden="true"></span><h3>About</h3>
                </div>
                <div class="row" id="user-message">
                     <span class="glyphicon glyphicon-envelope"  aria-hidden="true"></span><h3>Send a message</h3>
                </div>
                <div class="row" id="user-socials">
                    <span class="glyphicon glyphicon-globe"  aria-hidden="true"></span><h3>Social Networks</h3>
                </div>
                <div class="row" id="user-subscribes">
                    <span class="glyphicon glyphicon glyphicon-heart"  aria-hidden="true"></span><h3>Subscribes</h3>
                </div>
            </div>
        </div>
    </div>



    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'wallet') ?>
    <?= $form->field($model, 'currency') ?>
    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'banned', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>
    <?= $form->field($model, 'verified', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
