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

			'videotranslation' => [

				'class' => 'app\modules\videotranslation\VideoTranslation',

			],

			'chat' => [

				'class' => 'app\modules\chat\Chat',

			],

			'categories' => [

				'class' => 'app\modules\categories\Categories',

			],

			'tags' => [

				'class' => 'app\modules\tags\Tags',

			],

		];
    }
}
