<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use rs\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Url::to('@web/../common/web/images/favicon.ico'); ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | Administration</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div id="toggle-wrapper">
		<div id="toggle"><img src="<?= Yii::$app->request->baseUrl; ?>/images/icons/menu.png"></div>
	</div>
	<div id="content-wrapper">
		<div id="content-header">
			<div id="content-headline">
				<h1><?= Html::encode($this->title) ?></h1>
				<?php if (isset($this->params['headline-buttons'])) { ?>
				<div class="btn-group headline-buttons"><?= $this->params['headline-buttons']; ?></div>
				<?php } ?>
			</div>
			<?= Breadcrumbs::widget([
	            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	        ]) ?>
		</div>
		<div id="content">
			<div id="alerts"><?= Alert::widget() ?></div>
	        <?= $content ?>
		</div>
	</div>
	<div id="sidebar-wrapper">
		<div id="sidebar">
			<div id="page-name"><?= Yii::$app->settingManager->get('general', 'site_name'); ?></div>
			<div class="avatar">
				<img src="http://orig11.deviantart.net/d2cf/f/2014/078/9/1/earthshaker_dota_2_steam_avatar_by_mawpls-d77j44t.jpg">
			</div>
			<ul class="sidebar-navigation">
				<li class="head"><?= Yii::$app->user->identity->email; ?></li>
				<li><a href="<?= Url::to(['/logout']); ?>">Abmelden</a></li>
				<li><a href="../">Hauptseite</a></li>
			</ul>
			<?= backend\widgets\GeneralSidebarNavigation::widget([
				'items' => [
					'overview' => 'Übersicht',
					'settings' => 'Einstellungen',
					'globals' => 'Globale Variablen',
					'users' => 'Benutzer',
                    'pages' => 'Seiten',
                    'navigations' => 'Navigationen',
				]
			]); ?>
			<?= backend\widgets\ExtensionsSidebarNavigation::widget(); ?>
			
			
			<?= Yii::$app->request->getPathInfo(); ?>  
			<?= "<br>"; ?>	
			<?= $this->context->route ?>
			<?= "<br>"; ?>	
			<?= Yii::$app->controller->getRoute(); ?>	
		</div>
	</div>
	
		
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>







<!--
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
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
--!>
