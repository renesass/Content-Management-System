<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = ['label' => 'Erweiterungen', 'url' => ['/settings/extensions']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
    	<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'label'); ?>
		<?= $form->field($model, 'name')->textInput(['class' => 'form-control name']); ?>
		<?= $form->field($model, 'table_name')->textInput(['class' => 'form-control name']); ?>
		<?= $form->field($model, 'source')->dropDownList($model->getSources(), ['class' => 'form-control name']); ?>
	    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
