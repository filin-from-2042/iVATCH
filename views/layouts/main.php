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

    <!--TOP MENU-->
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
        ['label' => 'Категории', 'url' => ['/channels/categories']]
	];
	if (Yii::$app->user->isGuest)
    {
        $items[]=  ['label' => 'Войти', 'url' => ['/site/login']];
        $items[]=  ['label' => 'Зарегистрироваться', 'url' => ['/users/registration']];
    }
	else
	{
		$items[]=['label' => 'Профиль', 'url' => 'index.php?r=users/default/view&username='. Yii::$app->user->identity->username .''];
		$items[]=['label' => 'Выйти (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'],  'linkOptions' => ['data-method' => 'post']];
	}
	echo Nav::widget([
		'options' => ['class' => 'navbar-nav navbar-right nav-list'],
		'items' => $items,
	]);
    NavBar::end();
	?>

    <!--JUMBOTRON-->
    <?= $this->render('jumbotron');?>

    <!--PARRALAX-->
    <?//=$this->render('parallax')?>


<!--	<div class="container">-->
<!--        <!--BREADCRUMBS-->
<!--		--><?//= Breadcrumbs::widget([
//			'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
//		]) ?>
<!---->
<!--        <!--CONTENT-->
<!--		--><?//= $content ?>
<!---->
<!--	</div>-->

    <section id="features" data-speed="4" data-type="background">
        <div class="container">
            <div class="body-content">
                <div class="row">
                    <?= $content ?>
                </div>

            </div>
        </div>
    </section>


</div>

<!--FOOTER-->
<?=$this->render('footer')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
