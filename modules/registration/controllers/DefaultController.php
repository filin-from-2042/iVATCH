<?php

namespace app\modules\registration\controllers;
use app\models\LoginForm;
use Yii;
use app\models\User;
use app\modules\registration\models\RegistrationForm;
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
        print_r($attributes);
        // user login or signup comes here
        $login_type = \yii\helpers\StringHelper::basename(get_class($client));
        $user = User::findByNetwork($attributes['id'],$login_type);
        if ($user){
            $login = new LoginForm();
            $login->load($user);
            $login->Login();
        }
        // register user
        else{
            // Generate unique username
            // Basically from name and surname
            $registration = new RegistrationForm();
            $registration->password_repeat=$registration->password = Yii::$app->security->generatePasswordHash($attributes['id']);
            $registration->username = $attributes['first_name']. '_' . $attributes['last_name'];
            $registration->save();
        }
    }
}