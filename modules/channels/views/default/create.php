<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\channels\widgets\channelsTags\ChannelsTags;
use bupy7\cropbox\Cropbox;

app\modules\channels\ChannelsCreateAsset::register($this);

?>
<div class="channels-create">

    <div class="channels-form">

        <?php $form = ActiveForm::begin(['options'=>['id'=>'channels_create']]); ?>
        <?php $form->validateOnSubmit = false;?>
        <?= $form->field($model, 'title')->textInput(['maxlength' => 100]) ?>

        <?=ChannelsTags::widget(['label'=>'Теги канала']);?>

        <?= $form->field($model, 'description')->textInput(['maxlength' => 255]) ?>

        <?=
        $form->field($model, 'image')->widget(Cropbox::className(), [
            'attributeCropInfo' => 'crop_info',
            'optionsCropbox' => [
                'boxWidth' => 300,
                'boxHeight' => 300,
                'cropSettings' => [
                    [
                        'width' => 300,
                        'height' => 300,
                    ],
                ],
            ],
            'previewUrl' => [
//                '/modules/users/images/default.jpg'
                '/web/images/default.jpg'
            ]
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Создать') , ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
