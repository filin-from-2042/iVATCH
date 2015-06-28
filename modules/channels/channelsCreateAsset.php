<?
namespace app\modules\channels;

use yii\web\AssetBundle;

class ChannelsCreateAsset extends AssetBundle
{
    public $sourcePath = '@app/modules/channels/';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/create.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset'
    ];
}