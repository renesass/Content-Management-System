<?php

use yii\helpers\Html;
use yii\helpers\Url;
use rs\widgets\ActiveForm;

$this->title = 'Globale Variablen';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<ul class="nav nav-tabs">
		<?php
		foreach ($groups as $group) {
			?>
			<li role="presentation"<?php if ($group->name == $name) echo ' class="active"'; ?>><a href="<?= Url::to(['/globals', 'name' => $group->name]); ?>"><?= $group->label ?></a></li>
			<?php
		}	
		?>
	</ul>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
	    <?php
		if ($model->showFields($form)) {
			echo Html::submitButton('Speichern', ['class' => 'btn btn-primary']);
		} ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>