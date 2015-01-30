<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="wrap">
	<?php
	NavBar::begin([
		'brandLabel' => false,
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top',
		],
	]);

	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right'],
		'items' => [
			['label' => 'Home', 'url' => ['/site/index']],
			['label' => 'About', 'url' => ['/site/about']],
			['label' => 'Contact', 'url' => ['/site/contact']],
			Yii::$app->user->isGuest ?
				['label' => 'Login', 'url' => ['/site/login']] :
				['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
				 'url' => ['/site/logout'],
				 'linkOptions' => ['data-method' => 'post']],
		],
	]);
    NavBar::end();
    // Site header
	?>
    <div class="jumbotron">
        <div class="row">
            <div class="col-lg-12">
                <div class="brand">
                    <div class="wrap">
                        <h1>
                            <a href="./">iva <span class="glyphicon glyphicon-facetime-video"></span>tch</a>
                        </h1>
                        <div class="slogan">Streaming service</div>
                    </div>
                </div>
            </div>
        </div>
    </div>


	<div class="container">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>


		<?= $content ?>
	</div>
</div>

<footer class="footer">
<!--	<div class="container">-->
<!--		<p class="pull-left">&copy; My Company --><?//= date('Y') ?><!--</p>-->
<!--		<p class="pull-right">--><?//= Yii::powered() ?><!--</p>-->
<!--	</div>-->
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <div class="map marker"></div>
                <p class="footer_description">IVATCH <br>
                    28 JACKSON BLVD STE 1020 <br>
                    CHICAGO, IL 60604-2340</p>
            </div>
            <div class="col-sm-4">
                <div class="marker phone"></div>
                <p class="footer_description">TELEPHONE: +1 800 603 6035 <br>
                    E-MAIL: MAIL@DEMOLINK.ORG</p>
            </div>
            <div class="col-sm-4">
                <p class="footer_description"><a href="<?php echo Yii::$app->homeUrl ?>">IVATCH  </a> © 2015 | Privacy Policy</p>
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

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
