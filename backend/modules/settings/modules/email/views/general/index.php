<?php
	
use yii\helpers\Url;
use yii\helpers\Html;
use rs\widgets\ActiveForm;

$this->title = 'E-Mail';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
	<ul class="nav nav-tabs">
		<li role="presentation" class="active"><a href="<?= Url::to(['/settings/email']); ?>">Allgemein</a></li>
		<li role="presentation"><a href="<?= Url::to(['/settings/email/messages']); ?>">Nachrichten</a></li>
	</ul>
</div>


<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'system_address'); ?>
        <?= $form->field($model, 'system_name'); ?>
        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>