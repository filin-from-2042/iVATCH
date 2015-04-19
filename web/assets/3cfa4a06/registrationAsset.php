<?
namespace app\modules\registration;

use yii\web\AssetBundle;

class RegistrationAsset extends AssetBundle
{
public $sourcePath = '@app/modules/registration/';
//public $jsOptions = ['position' => \yii\web\View::POS_END];
//public $basePath = '@webroot';
//public $baseUrl = '@web';
public $css = [
'css/style.css'
];
public $js = [
];
public $depends = [
'yii\web\YiiAsset',
'yii\bootstrap\BootstrapAsset',
'app\assets\AppAsset' // здесь указываем в зависимостях "общий" ассет-бандл в котором подключаются less и js для всех страниц, т.е. style.less и js.js.
];
}