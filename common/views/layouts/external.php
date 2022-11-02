<?php 
	
use yii\helpers\Html;
use yii\helpers\Url;
use rs\widgets\Alert;

$asset = 'common\assets\ExternalAsset';
$asset::register($this); 

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?=  Url::to('@web/images/favicon.ico'); ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> | <?php echo Yii::$app->settingManager->get('general', 'site_name'); ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
	<div class="wrapper">
		<?= Alert::widget(); ?>
		<div class="panel panel-default">
			<div class="panel-heading colored-primary"><h3 class="panel-title"><?= Html::encode($this->title) ?></h3></div>
			<div class="panel-body">
				<?= $content ?>
			</div>
		</div>
		<?php if (isset($this->params['outside'])) echo $this->params['outside']; ?>
	</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>