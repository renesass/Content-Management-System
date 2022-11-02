<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use rs\widgets\Permissions;
use yii\bootstrap\Tabs;

$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = ['label' => 'Benutzer', 'url' => ['/settings/users']];
$this->params['breadcrumbs'][] = ['label' => 'Gruppen', 'url' => ['/settings/users/groups']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<?= Tabs::widget([
		'navType' => 'nav-tabs inside-panel',
		'renderTabContent' => false,
		'items' => [
			[
				'label' => 'Allgemeines',
				'options' => ['id' => 'general'],
				'active' => true,
			], 
			[
				'label' => 'Rechte',
				'options' => ['id' => 'permissions'],
			],
		],
	]);	?>
	<div class="panel-body">
	    <?php $form = ActiveForm::begin(); ?>
	    <div class="tab-content">
		    <div id="general" class="tab-pane active">
			    <?= $form->field($model, 'label'); ?>
				<?= $form->field($model, 'name')->textInput(['class' => 'form-control name']); ?>
		    </div>
		    <div id="permissions" class="tab-pane">
			    <?= Permissions::widget(['form' => $form, 'model' => $model]); ?>
		    </div>
	    </div>
	    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>
