<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:36
 */
namespace app\modules\channels\widgets\channelsList;

use yii\web\AssetBundle;

class ChannelsListAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/channels/widgets/channelsList';

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