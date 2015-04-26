<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 19.04.15
 * Time: 9:13
 */
namespace app\assets;

use yii\web\AssetBundle;

class BootstrapSwitchAsset extends AssetBundle
{
    public $sourcePath = '@vendor/nostalgiaz/bootstrap-switch/dist';

    public $css = [
        'css/bootstrap3/bootstrap-switch.css'
    ];
    public $js = [
        'js/bootstrap-switch.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset'
    ];

}