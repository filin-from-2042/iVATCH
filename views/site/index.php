<?php
/* @var $this yii\web\View */
use yii\bootstrap\Carousel;

$this->title = 'iVATCH';

echo Carousel::widget([
     'items' => [
         '<img src="/web/images/car-1.jpg"/>',
         '<img src="/web/images/car-2.jpg"/>',
         '<img src="/web/images/car-3.jpg"/>',
         '<img src="/web/images/car-4.jpg"/>',
     ]
 ]);

?>


