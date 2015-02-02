<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\registration\RegistrationAsset;
//RegistrationAsset::register($this);

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-6  col-md-6  col-sm-6  col-xs-12 ">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to register:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
//            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-10\">{input}</div>\n<div class=\"col-lg-12 text-right\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-2 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
<!--    Block with socials -->
    <div class="col-lg-6  col-md-6  col-sm-6  col-xs-12 " id="register-socials">
        <h1>Or join with social network</h1>
<!--        <div class="row">-->
<!--            <div class="col-lg-6 single-social" id="register-fb">-->
<!--                <h3>Facebook</h3>-->
<!--            </div>-->
<!--            <div class="col-lg-6 single-social" id="register-tw">-->
<!--                <h3>Twitter</h3>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 single-social" id="register-gh">-->
<!--                <h3>GitHub</h3>-->
<!--            </div>-->
<!--            <div class="col-lg-6 single-social" id="register-g">-->
<!--                <h3>Google</h3>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 single-social" id="register-li">-->
<!--                <h3>LinkedIn</h3>-->
<!--            </div>-->
<!--            <div class="col-lg-6 single-social" id="register-lv">-->
<!--                <h3>Live</h3>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--            <div class="col-lg-6 single-social" id="register-fb">-->
<!--                <h3>Vkontakte</h3>-->
<!--            </div>-->
<!--            <div class="col-lg-6 single-social" id="register-fb">-->
<!--                <h3>Yandex</h3>-->
<!--            </div>-->
<!--        </div>-->

        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth']
        ]) ?>

    </div>
</div>

