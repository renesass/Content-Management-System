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
		<li role="presentation"><a href="<?= Url::to(['/settings/email']); ?>">Allgemein</a></li>
		<li role="presentation" class="active"><a href="<?= Url::to(['/settings/email/messages']); ?>">Nachrichten</a></li>
	</ul>
</div>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Wenn sich ein Benutzer neu registriert</h3></div>
			<div class="panel-body">
				<?= $form->field($model, 'active_user_activation_subject') ?>
				<?= $form->field($model, 'active_user_activation_message', ['options' => ['class' => 'no-border no-margin']])->textarea(['rows' => 10]) ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Wenn ein Benutzer intern (ohne Passwort) registriert wird</h3></div>
			<div class="panel-body">
				<?= $form->field($model, 'passive_user_activation_subject') ?>
				<?= $form->field($model, 'passive_user_activation_message', ['options' => ['class' => 'no-border no-margin']])->textarea(['rows' => 10]) ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Wenn eine E-Mail-Adresse verifiziert werden muss</h3></div>
			<div class="panel-body">
				<?= $form->field($model, 'email_verification_subject') ?>
				<?= $form->field($model, 'email_verification_message', ['options' => ['class' => 'no-border no-margin']])->textarea(['rows' => 10]) ?>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Wenn eine Passwortänderung gewünscht ist</h3></div>
			<div class="panel-body">
				<?= $form->field($model, 'password_changement_subject') ?>
				<?= $form->field($model, 'password_changement_message', ['options' => ['class' => 'no-border no-margin']])->textarea(['rows' => 10]) ?>
			</div>
		</div>
		<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>