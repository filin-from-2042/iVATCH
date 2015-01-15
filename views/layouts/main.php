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
		'brandLabel' => 'iVatch',
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
	?>

	<div class="container">
		<?= Breadcrumbs::widget([
			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		]) ?>

		<header id="header">
			<div class="header_wrap">
				<div id="stuck_container">
					<div class="container">
						<div class="row">
							<div class="grid_12">
								<div class="brand">
									<div class="wrap">
										<h1>
											<a href="http://livedemo00.template-help.com/wt_51781/">dab <span class="fa fa-bomb"></span> mb</a>
										</h1>

										<div class="slogan">Night Club</div>
									</div>
								</div>

								<nav>
									<ul class="sf-menu sf-js-enabled sf-arrows">
										<li class="current"><a class="fa-home" href="http://livedemo00.template-help.com/wt_51781/"></a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-1.html">About us</a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-2.html">News &amp; Events</a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-3.html">Parties</a></li>
										<li>
											<a class="sf-with-ul" href="http://livedemo00.template-help.com/wt_51781/index-4.html">Blog</a>
											<ul style="display: none;" class="sub-menu">
												<li><a href="#">Dolore ipsu</a></li>
												<li><a class="sf-with-ul" href="#">Consecte</a>
													<ul style="display: none;" class="sub-menu">
														<li><a href="#">Dolore ipsu</a></li>
														<li><a href="#">Consecte</a></li>
														<li><a href="#">Elit Conseq</a></li>
													</ul>
												</li>
												<li><a href="#">Elit Conseq</a></li>
											</ul>
										</li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-5.html">Contacts</a></li>
									</ul><select style="display: inline-block;" class="select-menu sf-menu sf-js-enabled sf-arrows"><option value="#">Navigate to...</option><option selected="selected" value="http://livedemo00.template-help.com/wt_51781/">&nbsp;Home</option><option value="http://livedemo00.template-help.com/wt_51781/index-1.html">&nbsp;About us</option><option value="http://livedemo00.template-help.com/wt_51781/index-2.html">&nbsp;News &amp; Events</option><option value="http://livedemo00.template-help.com/wt_51781/index-3.html">&nbsp;Parties</option><option value="http://livedemo00.template-help.com/wt_51781/index-4.html">&nbsp;Blog</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Dolore ipsu</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Consecte</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Dolore ipsu</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Consecte</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Elit Conseq</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Elit Conseq</option><option value="http://livedemo00.template-help.com/wt_51781/index-5.html">&nbsp;Contacts</option></select>
								</nav>
							</div>
						</div>
					</div>
				</div>
				<div style="top: -64px; visibility: hidden; position: fixed; width: 100%;" class="isStuck" id="stuck_container">
					<div class="container">
						<div class="row">
							<div class="grid_12">
								<div class="brand">
									<div class="wrap">
										<h1>
											<a href="http://livedemo00.template-help.com/wt_51781/">dab <span class="fa fa-bomb"></span> mb</a>
										</h1>

										<div class="slogan">Night Club</div>
									</div>
								</div>

								<nav>
									<ul class="sf-menu sf-js-enabled sf-arrows">
										<li class="current"><a class="fa-home" href="http://livedemo00.template-help.com/wt_51781/"></a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-1.html">About us</a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-2.html">News &amp; Events</a></li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-3.html">Parties</a></li>
										<li>
											<a class="sf-with-ul" href="http://livedemo00.template-help.com/wt_51781/index-4.html">Blog</a>
											<ul style="display: none;" class="sub-menu">
												<li><a href="#">Dolore ipsu</a></li>
												<li><a class="sf-with-ul" href="#">Consecte</a>
													<ul style="display: none;" class="sub-menu">
														<li><a href="#">Dolore ipsu</a></li>
														<li><a href="#">Consecte</a></li>
														<li><a href="#">Elit Conseq</a></li>
													</ul>
												</li>
												<li><a href="#">Elit Conseq</a></li>
											</ul>
										</li>
										<li><a href="http://livedemo00.template-help.com/wt_51781/index-5.html">Contacts</a></li>
									</ul><select style="display: inline-block;" class="select-menu sf-menu sf-js-enabled sf-arrows"><option value="#">Navigate to...</option><option selected="selected" value="http://livedemo00.template-help.com/wt_51781/">&nbsp;Home</option><option value="http://livedemo00.template-help.com/wt_51781/index-1.html">&nbsp;About us</option><option value="http://livedemo00.template-help.com/wt_51781/index-2.html">&nbsp;News &amp; Events</option><option value="http://livedemo00.template-help.com/wt_51781/index-3.html">&nbsp;Parties</option><option value="http://livedemo00.template-help.com/wt_51781/index-4.html">&nbsp;Blog</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Dolore ipsu</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Consecte</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Dolore ipsu</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Consecte</option><option value="http://livedemo00.template-help.com/wt_51781/#">––&nbsp;Elit Conseq</option><option value="http://livedemo00.template-help.com/wt_51781/#">–&nbsp;Elit Conseq</option><option value="http://livedemo00.template-help.com/wt_51781/index-5.html">&nbsp;Contacts</option></select>
								</nav>
							</div>
						</div>
					</div>
				</div></div>
		</header>


		<?= $content ?>
	</div>
</div>

<footer class="footer">
	<div class="container">
		<p class="pull-left">&copy; My Company <?= date('Y') ?></p>
		<p class="pull-right"><?= Yii::powered() ?></p>
	</div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
