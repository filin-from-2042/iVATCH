<?php

namespace app\modules\registration\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

	public function actionUser()
	{
		return $this->render('user_page');
	}


}
