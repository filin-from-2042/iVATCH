<?php

namespace app\modules\channels;

class Channels extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\channels\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here

		$this->modules = [

			'VideoTranslation' => [

				'class' => 'app\modules\videotranslation\VideoTranslation',

			],

			'Chat' => [

				'class' => 'app\modules\chat\Chat',

			],

			'Categories' => [

				'class' => 'app\modules\categories\Categories',

			],

			'Tags' => [

				'class' => 'app\modules\tags\Tags',

			],

		];
    }
}
