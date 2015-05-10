<?php
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use \app\modules\registration\models\LoginForm;
use \app\modules\registration\models\RegistrationForm;

Modal::begin(['id' => 'modal',
    'header' => '<h1>Log in or register</h1>',
    'size'=>'large'	]);

    $modelLogin = new LoginForm();
    $htmlLog = $this->render('@app/modules/registration/views/login', ['model'=>$modelLogin]);

    $modelReg = new RegistrationForm();
    $htmlReg = $this->render('@app/modules/registration/views/registration', ['model'=>$modelReg]);

    // Block with socials
    echo '<div class="col-xs-12 " id="register-socials">';
        echo   '<h1>Join with social network</h1>';
        echo     yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['users/registration/default/auth'],
        ]);
    echo '</div>';

    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Log in',
                'content' => $htmlLog,
                'active' => true
            ],
            [
                'label' => 'Register',
                'content' => $htmlReg,
                'headerOptions' => [''],
                'options' => ['id' => 'modalForm'],
            ],

        ],
    ]);

Modal::end();
