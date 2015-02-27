<?php

namespace app\modules\channels\controllers;

use yii\web\Controller;

class WatchController extends Controller
{
    /**
     * Lists all Channels models.
     * @return mixed
     */
    public function actionIndex()
    {
		return $this->render('index');
    }
}