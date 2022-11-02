<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title">Benutzer</h3></div>
	<div class="panel-body">
		<?= $form->field($model, 'email')->textInput() ?>
		<?= $form->field($model, 'first_name')->textInput() ?>
		<?= $form->field($model, 'last_name')->textInput() ?>
        <?= Html::a('Passwort ändern <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>', ['/actions/users/set-password', 'token' => Yii::$app->user->identity->password_token], ['target'=>'_blank']) ?>
	</div>
</div>
		
<div class="panel panel-default">
	<div class="panel-heading"><h3 class="panel-title">Profil</h3></div>
	<div class="panel-body no-padding-bottom">
		<?php $profileModel->showFields($form); ?>
	</div>
</div>

<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>