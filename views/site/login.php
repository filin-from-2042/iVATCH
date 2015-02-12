<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use app\modules\registration\models\RegistrationForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-4 control-label'],

        ],
        'enableAjaxValidation' => true,
        'validationUrl'=>['/site/login'],
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
	<div class="col-md-offset-4 col-md-4">
		<?= $form->field($model, 'rememberMe', [
			'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4\">{error}</div>",
		])->checkbox() ?>
	</div>
    <div class="form-group  text-center">
        <div class="col-lg-offset-4 col-lg-4">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button', 'data-loading-text'=>'Loading...', 'id'=>'login-submit'] ) ?>
        </div>
	</div>
	<div class="clearfix"></div>
    <?php ActiveForm::end(); ?>


</div>

