<?php if (Yii::$app->globalManager->get('news-flash', 'activated')) { ?>
<div class="sidebar-point">
	<h3 class="sidebar-heading">Kurzmeldung</h3>
	<div class="sidebar-text"><?= Yii::$app->globalManager->get('news-flash', 'message') ?></div>
</div>
<?php } ?>

<div class="sidebar-point">
	<h3 class="sidebar-heading">Nächste Termine</h3>
	<?= \common\plugins\events\widgets\Events::widget([
		'name' => 'events',
	]); ?>
</div>

<div class="sidebar-point no-margin">
	<h3 class="sidebar-heading">Kontakt</h3>
	<div class="sidebar-text">
		Martin-Luther Gemeinde<br>
		Limbergstraße 29<br>
		38518 Gifhorn<br><br>
		<a href="mailto:info@weforg.de">info@weforg.de</a>
	</div>
</div>