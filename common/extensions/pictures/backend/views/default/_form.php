<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => $extension->label, 'url' => ['/'.$extension->name]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
	    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
		<?= $form->field($model, 'title'); ?>
		<?= $form->field($model, 'description')->textArea(['rows' => 5]); ?>
		<?= $form->field($model, 'location'); ?>
		<?= $form->field($model, 'date')->textInput(['placeholder' => 'DD.MM.YYYY']); ?>
		<?= $form->field($model, 'image')->fileInput(); ?>
	    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
