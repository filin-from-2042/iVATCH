<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\channels\models\Channels */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs('
    jQuery(document).ready(
        function()
        {
            $("#channels_create").on("submit",
                function(event)
                {
                    event.preventDefault();
                    $.post("/web/index.php?r=channels/ajax/create",
                        $(this).serialize(),
                        function(response)
                        {

                        }
                    );
                }
            );
        }
    );
');

?>

<div class="channels-form">

    <?php $form = ActiveForm::begin(['options'=>['id'=>'channels_create']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'image_path')->textInput() ?>

    <?= $form->field($model, 'tariff_id')->textInput() ?>

    <?= $form->field($model, 'tariff_start')->textInput() ?>

    <?= $form->field($model, 'tariff_end')->textInput() ?>

    <?= $form->field($model, 'subscribers_count')->textInput() ?>

    <?= $form->field($model, 'subscribe_plan')->dropDownList([ 'free' => 'Free', 'pay' => 'Pay', 'donate' => 'Donate', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'subscription_cost')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create') , ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
