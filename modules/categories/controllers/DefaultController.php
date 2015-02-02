<?php

namespace app\modules\categories\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

	public function getRoute()
	{
		return 'channels/categories';
	}
}
