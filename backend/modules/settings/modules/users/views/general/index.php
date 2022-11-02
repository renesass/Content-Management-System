<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->title = 'Benutzer';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="<?= Url::to(['/settings/users']); ?>">Allgemein</a></li>
		<li role="presentation"><a href="<?= Url::to(['/settings/users/groups']); ?>">Gruppen</a></li>
	</ul>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'public_registration')->checkbox(); ?>
        <?= $form->field($model, 'verification')->checkbox(); ?>
        <?= $form->field($model, 'verification_period'); ?>
		<?= $form->field($model, 'field_ids')->listBox(Yii::$app->fieldManager->getFields(), ['multiple' => 'multiple', 'size' => 7]) ?>
        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>
