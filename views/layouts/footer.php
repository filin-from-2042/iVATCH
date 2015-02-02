<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="map marker"></div>
                <p class="footer_description"><?=Yii::$app->name?> <?=Yii::$app->params['contact_address']?></p>
            </div>
            <div class="col-sm-4">
                <div class="marker phone"></div>
                <p class="footer_description">Телефон:<?=Yii::$app->params['phone']?><br>
                    E-MAIL:<?=Yii::$app->params['email']?></p>
            </div>
            <div class="col-sm-4">
                <p class="footer_description"><a href="<?=Yii::$app->homeUrl?>"><?=Yii::$app->name?></a> © <?= date('Y') ?> | Privacy Policy</p>
                <ul class="social-list">
                    <li><a class="fa fa-facebook" href="#"></a></li>
                    <li><a class="fa fa-rss" href="#"></a></li>
                    <li><a class="fa fa-twitter" href="#"></a></li>
                    <li><a class="fa fa-google-plus" href="#"></a></li>
                </ul>
            </div>
        </div>

    </div>
</footer>