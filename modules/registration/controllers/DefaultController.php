<?php

namespace app\modules\registration\controllers;
use app\models\LoginForm;
use Yii;
use app\models\User;
use app\modules\registration\models\RegistrationForm;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        // Check if form was submitted

//        $model = new User();
//        // Button submit
//        if(isset($_POST['register-button']) && $model->load($_POST))
//        {
//            $model->save();
//            $login = new LoginForm();
//            $login->load($model->_attributes);
//            return;
//        }
//
//        // Ajax validation
//        if (Yii::$app->request->isAjax && $model->load($_POST)) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }
//
//        return $this->render('index',[
//            'model' => $model]);
//    }

        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $login = new LoginForm();
            $login->load(Yii::$app->request->post());
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