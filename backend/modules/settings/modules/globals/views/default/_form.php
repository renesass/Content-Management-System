<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = ['label' => 'Globale Variablen', 'url' => ['/settings/globals']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'label'); ?>
		<?= $form->field($model, 'name')->textInput(['class' => 'form-control name']); ?>
		<?= $form->field($model, 'field_ids')->listBox(Yii::$app->fieldManager->getFields(), ['multiple' => 'multiple', 'size' => 7]) ?>
		<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>