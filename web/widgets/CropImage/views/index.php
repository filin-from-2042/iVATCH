<?php
/**
 * Created by PhpStorm.
 * User: Set
 * Date: 12.04.15
 * Time: 11:19
 */
use webroot\widgets\CropImage\CropImageAsset;
use yii\helpers\Html;

CropImageAsset::register($this);

?>
<div id="crop-image-widget" class="container">
    <div>
        <input type="file" id="channels-image-path" name="image_path"">
    </div>
    <?=Html::img('/modules/users/images/default.jpg', ['alt'=>'default-avatar', 'class'=>'img-responsive','id'=>'dummy','width'=>'500']);?>
    <div id="image_container">
        <canvas id="panel" width="500" height="500"></canvas>
    </div>
</div>


<!--<img src="" id="image_preview">-->