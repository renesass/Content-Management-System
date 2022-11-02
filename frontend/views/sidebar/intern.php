<div class="sidebar-point">
	<h3 class="sidebar-heading">Navigation</h3>
	<?= \yii\widgets\Menu::widget([
		'options'=> ['class' => 'sidebar-menu'],
	    'items' => \rs\navigations\SubNavigation::getItems(),
	]); ?>
</div>

<div class="sidebar-point last">
    <h3 class="sidebar-heading">Nächste Geburtstage</h3>
    <?= \frontend\widgets\NextBirthdays::widget(['items' => 5]); ?>
</div>