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


	public function getRoute()
	{
		return 'users/registration';
	}
}