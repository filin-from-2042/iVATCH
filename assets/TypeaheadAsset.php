<?php
namespace app\assets;

use yii\web\AssetBundle;

class TypeaheadAsset extends AssetBundle
{
    public $sourcePath = '@vendor/typeahead 0.11.1.';

    public $css = ['style.css'];
    public $js = [
        'typeahead.bundle.js',
        'bloodhound.js'
    ];

}