<?php

namespace app\modules\registration\controllers;

use Yii;
use app\models\User;
use app\modules\registration\models\RegistrationForm;
use app\modules\registration\models\SocialRegistration;
use app\modules\registration\models\SocialLogin;
use app\modules\registration\models\LoginForm;
use yii\base\Model;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $model = new RegistrationForm();

		if (Yii::$app->request->isAjax && $model->load($_POST))
		{
            Yii::$app->response->format = 'json';
            $validate = \yii\widgets\ActiveForm::validate($model);

            if ($validate==false && isset($_POST['register-button']) && $model->load(Yii::$app->request->post()) && $model->save()) {
                $login = new LoginForm();
                $login->username = $_POST['RegistrationForm']['username'];
                $login->password = $_POST['RegistrationForm']['password'];
                $login->Login();
                return $this->redirect('index.php?r=users/default/view&username='. Yii::$app->user->identity->username .'');
            }
            return $validate;
		}

        return $this->render('index', [
                'model' => $model,
            ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        if (Yii::$app->request->isAjax && $model->load($_POST))
        {
            Yii::$app->response->format = 'json';
            return \yii\widgets\ActiveForm::validate($model);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

	public function GenerateUserName(){
		// generate username

		$file = (isset($_GET['f']) && !empty($_GET['f'])) ? $_GET['f'] : 'random' ;
		$name = Mudnames::generate_name_from($file);
		return $name;
	}



//	public function getRoute()
//	{
//		return 'users/registration';
//	}


    public function actions()
    {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        // user login or signup comes here
        $login_type = \yii\helpers\StringHelper::basename(get_class($client));
        $login = new SocialLogin();
		// try to register
	    $registration = new SocialRegistration();
	    $registration->login_type = $login_type;
	    $registration->login_id = $attributes['id'];
	    // generate username
	    $registration->username = $this->GenerateUserName();
	    $registration->save();
        // try to log in
        $login->login_type=$login_type;
        $login->login_id=$attributes['id'];
        $login->Login();
    }
}