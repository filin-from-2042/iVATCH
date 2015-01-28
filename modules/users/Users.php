<?php

namespace app\modules\users;

class Users extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\users\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
		$this->modules = [

			'Registration' => [

				'class' => 'app\modules\registration\Registration',

			]

		];
    }
}
