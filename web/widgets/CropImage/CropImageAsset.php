<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 31.03.15
 * Time: 21:36
 */
namespace webroot\widgets\CropImage;

use yii\web\AssetBundle;

class CropImageAsset extends AssetBundle
{
    public $sourcePath = '@webroot/widgets/CropImage';
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