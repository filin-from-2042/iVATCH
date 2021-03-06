<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:37
 */
namespace webroot\widgets\watching;

use yii\web\AssetBundle;

class WatchingPlayerAsset extends AssetBundle
{
    public $sourcePath = '@webroot/widgets/watching';
//    public $css = [
//        'css/style.css'
//    ];
    public $js = [
        'js/lib/adapter.js',
        'js/lib/socket.io.js',
        'js/watch-player.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset' // здесь указываем в зависимостях "общий" ассет-бандл в котором подключаются less и js для всех страниц, т.е. style.less и js.js.
    ];
}