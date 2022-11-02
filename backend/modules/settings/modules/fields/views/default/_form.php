<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use rs\widgets\ActiveForm;
use backend\modules\settings\modules\fields\models\FieldGroup;

$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = ['label' => 'Felder', 'url' => ['/settings/fields']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(<<<JS
    $(document).ready(function() {
		$("#type-details-" + $("#type").val()).removeClass("hidden");
	});
	
	// show details from selected type
	$('#type').on('change', function() {
		$('.type-details').addClass("hidden");
		$('#type-details-' + this.value).removeClass("hidden");
	});
	
	$('.add-item').on('click', function() {
		var to = $($(this).attr('to-table'));
		var tbody = to.find('tbody');
		var index = tbody.children().length - 1;
		var type = $(this).attr('type');
		var attribute = $(this).attr('attribute');
		
		tbody
			.append($('<tr>')
				.append($('<td>')
					.attr('class', 'name')
					.append($('<input>')
						// .attr('id', ''+type+'-'+attribute+'-'+index+'-name')
						.attr('name', ''+type+'['+attribute+']['+index+'][name]')
						.attr('type', 'text')
					)
				)
				.append($('<td>')
					.append($('<input>')
						// .attr('id', ''+type+'-'+attribute+'-'+index+'-value')
						.attr('name', ''+type+'['+attribute+']['+index+'][value]')
						.attr('type', 'text')
					)
				)
			);
	});
	
	$('.remove-item').on('click', function() {
		var from = "table" + $(this).attr('from-table');
		var fromTr = $(from + " tr");
		
		if (fromTr.length > 1) {
			fromTr[fromTr.length - 1].remove();
		}
	});
JS
);

?>

<div class="panel panel-default">
	<div class="panel-body">
	    <?php $form = ActiveForm::begin(); ?>
		<?= $form->field($model, 'group_id')->dropDownList([0 => "Keiner Gruppe zugewiesen"] + ArrayHelper::map(FieldGroup::find()->all(), 'id', 'label')); ?>
	    <?= $form->field($model, 'label') ?>
	    <?= $form->field($model, 'name')->textInput(['class' => 'form-control name']); ?>
	    <?= $form->field($model, 'hint')->textArea(['rows' => '6']); ?>
	    <?= $form->field($model, 'type')->dropDownList(Yii::$app->fieldManager->getTypeNames()); ?>
	    <?php
		
		if (is_array($types = $model->types)) {
			foreach ($types as $type) {
				?>
				<div id="type-details-<?= lcfirst($type->formName()); ?>" class="type-details hidden">
					<?php
					foreach ($type->attributes() as $attribute) {
						if (method_exists($type, 'attributeTypes')) {
							$attributeType = $type->attributeTypes()[$attribute] ?? null;
						}
						
						if (!empty($attributeType)) {
							if ($attributeType == "key-value") { ?>
								<div class="form-group">
								<?= Html::activeLabel($type, $attribute); ?>
								<div class="pull-right">
									<span class="glyphicon glyphicon-plus add-item" to-table="#<?= Html::getInputId($type, $attribute); ?>" type="<?= $type->formName() ?>" attribute="<?= $attribute ?>"></span>
									<span class="glyphicon glyphicon-minus remove-item" from-table="#<?= Html::getInputId($type, $attribute); ?>" type="<?= $type->formName() ?>" attribute="<?= $attribute ?>"></span>
								</div>
								<table class="table-bordered key-value form-group" id="<?= Html::getInputId($type, $attribute); ?>">
									<tr>
										<th>Name</th>
										<th>Wert</th>
									</tr>
									<?php
									foreach (array_keys($type->$attribute) as $index) {
										?>
										<tr>
											<td class="name"><?= $form->field($type, "{$attribute}[$index][name]", ['template' => '{input}', 'options' => ['tag' => false]])->textInput(['id' => '', 'class' => '']) ?></td>
											<td><?= $form->field($type, "{$attribute}[$index][value]", ['template' => '{input}', 'options' => ['tag' => false]])->textInput(['id' => '', 'class' => '']) ?></td>
										</tr>
										<?php 
									}
									?>
								</table>
								</div>
							<?php
							} else {
								echo $form->field($type, $attribute)->$attributeType();
							}
						} else {
							echo $form->field($type, $attribute)->textInput();
						}
					}
					?>
				</div>
				<?php 
			}
		}
		?>
		<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>