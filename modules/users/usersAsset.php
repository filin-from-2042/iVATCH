<?
namespace app\modules\users;

use yii\web\AssetBundle;

class UsersAsset extends AssetBundle
{
    public $publishOptions = ['forceCopy' => true];
    public $sourcePath = '@app/modules/users/';
    //public $jsOptions = ['position' => \yii\web\View::POS_END];
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $css = [
    'css/style.css'
    ];
    public $js = [
        'js/avatar_upload.js',
//        '@bower/jquery/dist'
    ];
    public $depends = [
    'yii\web\YiiAsset',
    'yii\bootstrap\BootstrapAsset',
    'app\assets\AppAsset' // здесь указываем в зависимостях "общий" ассет-бандл в котором подключаются less и js для всех страниц, т.е. style.less и js.js.
    ];
}