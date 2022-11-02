<?php
	
use rs\widgets\Alert;
	
?>

<?php $this->beginContent('@frontend/views/layouts/main.php'); ?>

<div id="main-content">
    <h1><?= Yii::$app->controller->view->title ?></h1>
	<div id="alerts"><?= Alert::widget() ?></div>
	<?= $content ?>
</div>
<div id="sidebar">
	<?= Yii::$app->controller->sidebar ?>
</div>

<?php $this->endContent(); ?>