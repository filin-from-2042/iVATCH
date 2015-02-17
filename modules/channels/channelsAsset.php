<?
namespace app\modules\channels;

use yii\web\AssetBundle;

class ChannelsAsset extends AssetBundle
{
//    public $basePath = '@webroot';
//    public $baseUrl = '@web';
    public $sourcePath = '@app/modules/channels/';
//    public $css = [
//        'css/style.css'
//    ];
    public $js = [
        'js/lib/adapter.js',
        'js/player.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset' // здесь указываем в зависимостях "общий" ассет-бандл в котором подключаются less и js для всех страниц, т.е. style.less и js.js.
    ];
}