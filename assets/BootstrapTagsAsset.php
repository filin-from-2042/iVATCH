<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 19.04.15
 * Time: 9:13
 */
namespace app\assets;

use yii\web\AssetBundle;

class BootstrapTagsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/bootstrap-tagsinput';

    public $css = [
        'bootstrap-tagsinput.css'
    ];
    public $js = [
        'bootstrap-tagsinput.js'
    ];

}