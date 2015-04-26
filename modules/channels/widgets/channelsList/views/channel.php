<?php
use yii\helpers\Html;
?>
<div class="channel_preview">
    <?php
    echo Html::encode("{$title} ({$description})");
    echo ':';
    echo $category_id ;
    ?>
</div>