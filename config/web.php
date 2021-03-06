<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'UVATCH',
    'modules' => [

        'channels' => [

            'class' => 'app\modules\channels\Channels',

        ],
        'news' => [

            'class' => 'app\modules\news\News',

        ],
		'actions' => [

			'class' => 'app\modules\actions\Actions',

		],
		'users' => [

			'class' => 'app\modules\users\Users',

		],
		'events' => [

			'class' => 'app\modules\events\Events',

		],
    ],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'components' => [
        'assetManager' => [
            // some how preserve css cache. Remove in production
//            'linkAssets' => true,
        'forceCopy' => true
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOpenId'
                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '415735628596031',
                    'clientSecret' => 'e66d59b2677f5693d48f1d77c6c47b30',
                ],
//                'github' => [
//                    'class' => 'yii\authclient\clients\GitHub',
//                ],
                'LinkedIn' => [
                    'class' => 'yii\authclient\clients\LinkedIn',
                ],
//                'Live' => [
//                    'class' => 'yii\authclient\clients\Live',
//                ],
                'Twitter' => [
                    'class' => 'yii\authclient\clients\Twitter',
                ],
                'Vkontakte' => [
                  'class' => 'yii\authclient\clients\VKontakte',
                  'clientId' => '4765519',
                  'clientSecret' => 'F4LvBSQDtpluxH1QyLPE',
                  'scope' => 'email'
                ],
                'Yandex' => [
                    'class' => 'yii\authclient\clients\YandexOAuth',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'LtZwZbAL1Z0syBA-QaGdbP0xHQToujhn',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\registration\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
