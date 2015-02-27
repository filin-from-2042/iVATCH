<?php

namespace app\modules\channels\controllers;

use yii\web\Controller;

class BroadcastController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}