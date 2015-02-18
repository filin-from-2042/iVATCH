<?php
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;

Modal::begin(['id' => 'modal',
    'header' => '<h1>Log in or register</h1>',
    'size'=>'large'	]);
$modelLogin = new \app\models\LoginForm();
$html = $this->render('@app/views/site/login', ['model'=>$modelLogin]);

$modelReg = new \app\modules\registration\models\RegistrationForm();
$htmlReg = $this->render('@app/modules/registration/views/default/index', ['model'=>$modelReg]);

// Block with socials
echo '<div class="col-xs-12 " id="register-socials">';
echo   '<h1>Join with social network</h1>';
echo     yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['users/registration/default/auth']
]);
echo '</div>';

echo Tabs::widget([
    'items' => [
        [
            'label' => 'Log in',
            'content' => $html,
            'active' => true
        ],
        [
            'label' => 'Register',
            'content' => $htmlReg,
            'headerOptions' => [''],
            'options' => ['id' => 'myveryownID'],
        ],

    ],
]);

Modal::end();
