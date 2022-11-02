<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Benutzer', 'url' => ['/users']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<table class="table">
		<tr><td> 
		<?php
		if ($model->isSuspended()) {
			echo '<span class="glyphicon glyphicon-dot red with-right-margin" aria-hidden="true"></span> '.$model::statusLabel($model::STATUS_SUSPENDED);
		}
		else if ($model->isPending()) {
			echo '<span class="glyphicon glyphicon-dot yellow with-right-margin" aria-hidden="true"></span> '.$model::statusLabel($model::STATUS_PENDING);
		}
		else if ($model->isActive()) {
			echo '<span class="glyphicon glyphicon-dot green with-right-margin" aria-hidden="true"></span> '.$model::statusLabel($model::STATUS_ACTIVE);
		}
			
		?></td></tr>
		<tr><td>Registriert seit: <?= date("d. F Y", $model->created_at); ?></td></tr>
		<tr><td>Zuletzt angemeldet: <?= (!empty($model->last_login)) ? date("d. F Y", $model->last_login) : "nie"; ?></td></tr>
	</table>
	<div class="panel-body">
		<?php // if (!administrator) ?>
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Aktionen
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<?php
					
				// request new password
				if ($model->canChangePassword()) {
					echo '<li>'.Html::a('E-Mail zur Passwortänderung schicken', Url::to(['/users/send-password-changement', 'id' => $model->id]), ['data-method' => 'post']).'</li>';
					echo '<li>'.Html::button('Link zur Passwortänderung kopieren', [
						'onclick' => "return prompt('Link für neues Passwort', '".Yii::$app->urlManagerFrontend->createAbsoluteUrl(['actions/users/set-password', 
						'token' => $model->password_token])."')"
					]).'</li>';
				}
				
				// activate user
				if ($model->isPending()) {
					echo '<li>'.Html::a('E-Mail zur Benutzeraktivierung schicken', Url::to(['/users/send-user-activation', 'id' => $model->id]), ['data-method' => 'post']).'</li>';
					echo '<li>'.Html::button('Link zur Benutzeraktivierung kopieren', [
						'onclick' => "return prompt('Link für Aktivierung', '".Yii::$app->urlManagerFrontend->createAbsoluteUrl(['actions/users/activate', 
						'token' => $model->activation_token])."')"
					]).'</li>';
				}
				
				// verify new email
				if ($model->hasUnconfirmedEmail()) {
					echo '<li>'.Html::a('E-Mail zur E-Mail-Überprüfung schicken', Url::to(['/users/send-email-verification', 'id' => $model->id]), ['data-method' => 'post']).'</li>';
					echo '<li>'.Html::button('Link zur E-Mail-Überprüfung kopieren', [
						'onclick' => "return prompt('Link zur E-Mail-Bestätigung', '".Yii::$app->urlManagerFrontend->createAbsoluteUrl(['actions/users/verify', 
						'token' => $model->verification_token])."')"
					]).'</li>';
				}
				
                if ($model->canChangePassword() || $model->isPending() || $model->hasUnconfirmedEmail()) {
				    echo '<li role="separator" class="divider"></li>';
                }
				
				// suspend / unsuspend
				if ($model->isSuspended()) {
					echo '<li><a href="'.Url::to(['/users/unsuspend', 'id' => $model->id]).'">Entsperren</a></li>';
				} else {
					echo '<li><a href="'.Url::to(['/users/suspend', 'id' => $model->id]).'">Sperren</a></li>';
				}
				
				// delete
				echo '<li>'.Html::a('Löschen', ['/users/delete', 'id' => $model->id], [
					'data-pjax' => 0,
					'data-confirm' => 'Willst du den Benutzer wirklich löschen? Diese Aktion kann nicht rückgängig gemacht werden.',
					'data-method' => 'post',
				]).'</li>';
				?>
				</li>
  			</ul>
		</div>
	</div>
</div>

<?= $this->render('_form', [
	'model' => $model,
    'profileModel' => $profileModel,
]) ?>

