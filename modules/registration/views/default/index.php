<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\modules\registration\RegistrationAsset;
RegistrationAsset::register($this);

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Register';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">
    <div class="col-lg-12  col-md-12  col-sm-12  col-xs-12 ">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Please fill out the following fields to register:</p>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
//            'enableAjaxValidation' => true,
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-4 text-right\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-4 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-4">
                <?= Html::submitButton('Register', ['class' => 'btn btn-primary btn-block', 'name' => 'register-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>


