<?php

namespace app\modules\registration\controllers;
use app\models\LoginForm;
use Yii;
use app\models\User;
use app\modules\registration\models\RegistrationForm;
use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $login = new LoginForm();
            $login->username = $_POST['User']['username'];
            $login->password = $_POST['User']['password'];
            $login->Login();
            return $this->redirect('index.php?r=users/default/view&username='. Yii::$app->user->identity->username .'');
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }

    }

	public function getRoute()
	{
		return 'users/registration';
	}
}