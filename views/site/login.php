<?php

use yii\bootstrap\Tabs;
use \app\modules\registration\models\LoginForm;
use \app\modules\registration\models\RegistrationForm;

$modelLogin = new LoginForm();
$htmlLog = $this->render('@app/modules/registration/views/login', ['model'=>$modelLogin]);

$modelReg = new RegistrationForm();
$htmlReg = $this->render('@app/modules/registration/views/registration', ['model'=>$modelReg]);

echo '<div class="container required_form">';
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
                'options' => ['id' => 'requiredForm'],
            ],

        ],
    ]);
echo '</div>';