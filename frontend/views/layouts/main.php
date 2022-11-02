<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use rs\widgets\Alert;
use rs\navigations\MainNavigation;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= Yii::$app->settingManager->get("general", "description"); ?>">
    <link rel="shortcut icon" href="<?= Url::to('@web/common/web/images/favicon.ico'); ?>">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:600">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:800">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | <?php echo Yii::$app->settingManager->get('general', 'site_name'); ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<!-- top area with navigation -->
	<?php
	$isFrontpage = false;
	if (Yii::$app->controller->navigationItem != null && Yii::$app->controller->navigationItem->home == 1) { 
	    $isFrontpage = true;
	}	
	?>
	<div id="top"<?php if(!$isFrontpage) echo ' class="shortened"'; ?>>
		<?php NavBar::begin([
			'options' => ['class' => 'navbar navbar-default navbar-fixed-top'],
	        'brandLabel' => Html::img('@web/images/logo.png', ['alt'=> Yii::$app->settingManager->get('general', 'site_name')]).Yii::$app->settingManager->get('general', 'site_name'),
	        'brandUrl' => Yii::$app->homeUrl
	    ]);

	    echo Nav::widget([
	        'options' => ['class' => 'navbar-nav navbar-right'],
	        'items' => MainNavigation::getItems(),
	    ]);
	    NavBar::end(); ?>
        <div id="title-content">
            <div class="section container" id="title"><?= Yii::$app->settingManager->get('general', 'title'); ?></div>
        </div>
	</div>
	
	<!-- page area with content and sidebar -->
	<div id="content">
		<div class="section container">
			<?php if (empty(Yii::$app->controller->sidebar)) {
                 echo '<h1>'.Yii::$app->controller->view->title.'</h1>';
				 echo '<div id="alerts">'.Alert::widget().'</div>'; 
			}?>
			<?= $content ?>
		</div>
	</div>
	<!-- footer area with contact -->
	<div id="footer">
		<div class="section container">Copyright &copy; 2002 - <?= date('Y'); ?> bei We for G</div>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
