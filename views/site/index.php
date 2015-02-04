<?php
/* @var $this yii\web\View */
use yii\bootstrap\Carousel;

$this->title = 'UVATCH';
?>

<section id="features" data-speed="4" data-type="background">
    <div class="container-fluid">
        <div class="body-content">
            <div class="row">
            <?php
                echo Carousel::widget([
                     'items' => [
                         '<img src="/web/images/camera%20(1).jpg"/>',
                         '<img src="/web/images/camera%20(10).jpg"/>',
                         '<img src="/web/images/camera%20(12).jpg"/>',
                         '<img src="/web/images/camera%20(14).JPG"/>',
                     ],
                    'controls'=>['<span class="left_arrow glyphicon glyphicon-chevron-left"></span>','<span class="right_arrow glyphicon glyphicon-chevron-right"></span>'],
                    'options'=>['class'=>'slide']
                 ]);
            ?>
            </div>
        </div>
    </div>
</section>


