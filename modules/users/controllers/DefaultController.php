<?php

namespace app\modules\users\controllers;

use yii\helpers\BaseUrl;
use yii\web\Controller;
use app\modules\registration\models\User;
use app\modules\channels\models\Channels;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;
use yii\imagine\Image;
use yii\filters\AccessControl;


class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $username = Yii::$app->user->identity->username;

        // Get user by nickname
        $model = User::findByUsername($username);

        if ($model === null) {
            throw new NotFoundHttpException;
        }

        // File save
        // TODO: move to a separate function
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstance($model, 'image_path');

            if ($file && $model->validate('image_path')) {
                $save_path = '/uploads/avatars/' . $username .'.'. $file->extension;
                $model->image_path =  $save_path;
                $file->saveAs(Yii::getAlias('@app').$save_path);
                $model->save('image_path');
                Image::thumbnail(Yii::getAlias('@app').$save_path, 1000,667)
                    ->save(Yii::getAlias('@app').$save_path, ['quality' => 80]);
            }
        }


        return $this->render('index', [
            'model' => $model,
            'channels'=>$model->channels,
        ]);
    }

    public function actionView($username)
    {
        // Get user by nickname
        $model = User::findByUsername($username);
        if ($model === null) {
            throw new NotFoundHttpException;
        }

        // File save
        // TODO: move to a separate function
        if (Yii::$app->request->isPost) {
            $file = UploadedFile::getInstance($model, 'image_path');

            if ($file && $model->validate('image_path')) {
                $save_path = '/uploads/avatars/' . $username .'.'. $file->extension;
                $model->image_path =  $save_path;
                $file->saveAs(Yii::getAlias('@app').$save_path);
                $model->save('image_path');
				Image::thumbnail(Yii::getAlias('@app').$save_path, 1000,667)
                     ->save(Yii::getAlias('@app').$save_path, ['quality' => 80]);
            }
        }


        return $this->render('view', [
            'model' => $model,
            'channels'=>$model->channels,
        ]);

    }

 }
