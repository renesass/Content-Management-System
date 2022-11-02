<div class="sidebar-point">
	<h3 class="sidebar-heading">Interner Bereich</h3>
	<?= \yii\widgets\Menu::widget([
		'options'=> ['class' => 'sidebar-menu'],
	    'items' => [
	        ['label' => 'Übersicht', 'url' => ['/intern/default/index'], 'active' => $this->context->route == 'intern/default'],
		    ['label' => 'Profil bearbeiten', 'url' => ['/intern/profile'], 'active' => $this->context->route == 'intern/profile'],
	        ['label' => 'Termine', 'url' => ['/intern/events/index']],
            ['label' => 'Dateien (in Bearbeitung)', 'url' => ['/intern']],
	        ['label' => "Mitgliederliste", 'url' => ['/intern/members/list'], 'linkOptions' => ['target'=>'_blank']],
	        ['label' => 'E-Mail an alle', 'url' => ['/intern/mail']],
	    ],
	]); ?>
</div>

<div class="sidebar-point last">
    <h3 class="sidebar-heading">Nächste Geburtstage</h3>
    <?= \frontend\widgets\NextBirthdays::widget(['items' => 5]); ?>
</div>