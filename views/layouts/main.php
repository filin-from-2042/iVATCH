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
		'brandLabel' => 'iva <span class="glyphicon glyphicon-facetime-video"></span>tch',
		'brandUrl' => Yii::$app->homeUrl,
		'options' => [
			'class' => 'navbar-inverse navbar-fixed-top top-menu',
		],
	]);
	// Nav menu
	$items = 	[
        ['label' => 'События', 'url' => ['/events']],
        ['label' => 'Категории', 'url' => ['/channels/categories/default/index']]
	];
	if (Yii::$app->user->isGuest)
    {
        $items[]=  ['label' => 'Login', 'url' => ['/site/login']];
        $items[]=  ['label' => 'Register', 'url' => ['/users/registration']];
    }
	else
	{
		$items[]=['label' => 'Profile', 'url' => 'index.php?r=users/default/view&username='. Yii::$app->user->identity->username .''];
		$items[]=['label' => 'Logout (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'],  'linkOptions' => ['data-method' => 'post']];
	}
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right nav-list'],
		'items' => $items,
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

    <? //TODO: TO CURTAIN VIEW OF CONTROLLER   ?>
    <!--     Parralax-->
    <section id="features" data-speed="4" data-type="background">
        <div class="container">
<!--            Content-->
            <div class="body-content">

                <div class="row">
                    <h2 id="feature_heading">
                        Hello there!
                    </h2>
                    <div class="col-sm-4 single_feature">
                        <h2 class="heading">Heading</h2>

                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                            fugiat nulla pariatur.</p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
                    </div>
                    <div class="col-sm-4 single_feature">
                        <h2 class="heading">Heading</h2>

                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                            fugiat nulla pariatur.</p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
                    </div>
                    <div class="col-sm-4 single_feature">
                        <h2 class="heading">Heading</h2>

                        <p class="description">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                            dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                            ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                            fugiat nulla pariatur.</p>

                        <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
                    </div>
                </div>

            </div>
        </div>
    </section>

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
