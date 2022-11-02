<?php if (Yii::$app->globalManager->get('news-flash', 'activated')) { ?>
<div class="sidebar-point">
	<h3 class="sidebar-heading">Kurzmeldung</h3>
	<div class="sidebar-text"><?= Yii::$app->replacer->replace(Yii::$app->globalManager->get('news-flash', 'message')) ?></div>
</div>
<?php } ?>

<div class="sidebar-point">
	<h3 class="sidebar-heading">Nächste Termine</h3>
	<?= \common\extensions\events\widgets\Events::widget([
		'name' => 'events',
	]); ?>
</div>

<div class="sidebar-point no-margin">
	<h3 class="sidebar-heading">Probenort</h3>
	<div class="sidebar-text">
		Martin-Luther Gemeinde<br>
		Limbergstraße 29<br>
		38518 Gifhorn
	</div>
</div>