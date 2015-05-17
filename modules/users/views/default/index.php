<?php
use yii\helpers\Html;
use app\modules\users\UsersAsset;
use app\components\UserChannelsWidget;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use app\modules\channels\widgets\channelsCreate\ChannelsCreate;
use app\modules\channels\models\Channels;

UsersAsset::register($this);
?>
<div class="container-fluid user-background" <? echo $model['background_path']?'style="background:url('.$model['background_path'] .') center"': ''?> >

        <div class="Users-default-index">
            <div class="container">
                <h2>User profile</h2>
                <h1><?=$model['username']?></h1>

                <div class="container-fluid user-info">
                    <div class="row">
                        <!--            // Display user pic of dummy-->
                        <div class="col-lg-8 col-md-8 cl-sm-6 col-xs-12" id="user-image">
                            <div class="wrapper_block">
                                <?=Html::img($model['image_path']?$model['image_path']:'/modules/users/images/default.jpg', ['alt'=>'default-avatar', 'class'=>'img-responsive']);?>
                                <div class="image_tooltip col-lg-12"><span class="glyphicon glyphicon-camera"></span><h3>Upload Image</h3></div>
                            </div>
                            <div class="user-image-upload">
                                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                                <?= $form->field($model, 'image_path')->fileInput() ?>
                                <button>Submit</button>
                                <?php ActiveForm::end(); ?>
                            </div>
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
            </div>
            <div class="container subscribers">
                <h1>Subscribers</h1>
            </div>
            <div class="container channels">
                <h1>Channels</h1>
                <?
                if ($channels)
                    echo UserChannelsWidget::widget(['dataProvider' =>  $channels]);
                else
                {
                    Modal::begin([
                        'header' => '<h2>Создание канала</h2>',
                        'toggleButton' => [
                            'tag' => 'button',
                            'class' => 'btn btn-lg btn-block btn-info',
                            'label' => 'Создать свой канал!',
                        ] ,
                    ]);
                    $model = new Channels();
                   // echo ChannelsCreate::widget([]);
                   echo     $this->render('@app/modules/channels/views/default/create', ['model'=>$model]);

                   Modal::end();

                }
                ?>
            </div>
            <div class="container achievements">
                <h1>Achievements</h1>
            </div>
        </div>
</div>
