<?php

namespace app\modules\users\controllers;

use yii\web\Controller;
use app\models\User;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($username)
    {
        // Get user by nickname
        $model = User::findByUsername($username);
        if ($model === null) {
            throw new NotFoundHttpException;
        }
        return $this->render('view', [
            'model' => $model,
            'image' => $model->image->image_path,
        ]);

    }
}
