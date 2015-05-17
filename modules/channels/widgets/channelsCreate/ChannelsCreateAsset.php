<?php

namespace app\modules\channels\widgets;

use yii\web\AssetBundle;

class ChannelsCreateAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/channels/widgets/сhannelsCreate';

    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/script.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset' // здесь указываем в зависимостях "общий" ассет-бандл в котором подключаются less и js для всех страниц, т.е. style.less и js.js.
    ];

}