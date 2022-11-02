<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

$this->params['breadcrumbs'][] = ['label' => 'Seiten', 'url' => ['/pages']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'label'); ?>
		<?= $form->field($model, 'text')->widget(CKEditor::className(), [
            'options' => ['rows' => 12],
            'preset' => 'advanced'
        ]); ?>
		<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>