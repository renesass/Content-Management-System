<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Termine', 'url' => ['/'.$extension->name]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
	    <?php $form = ActiveForm::begin(); ?>
	    <div class="row">
		    <div class="col-md-6">
			    <?= $form->field($model, 'date')->textInput(['placeholder' => 'DD.MM.YYYY']); ?>
		    </div>
		    <div class="col-md-6">
				<?= $form->field($model, 'time')->textInput(['placeholder' => 'HH:mm']); ?>
		    </div>
	    </div>
		<?= $form->field($model, 'type')->dropDownList([
			'Probe' => 'Probe', 
            'Probe mit Ehemaligen' => 'Probe mit Ehemaligen', 
			'Konzert' => 'Konzert', 
			'Jubiläumskonzert' => 'Jubiläumskonzert',
			'Gottesdienst' => 'Gottesdienst'
		]); ?>
		<?= $form->field($model, 'location'); ?>
		<?= $form->field($model, 'hint'); ?>
	    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
