<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use yii\bootstrap\Dropdown;
use common\yii\bootstrap\Icon;
use common\models\User;

?>

<?php $form = ActiveForm::begin(['id' => 'user-search', 'method' => 'POST']); ?>
<div class="input-group margin-bottom">
	<div class="input-group-btn">
		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			Sortierung
			<span class="caret"></span>
		</button>
		<ul class="dropdown-menu">
			<li<?php if (empty($model->status)) echo ' class="active"'; ?>>
				<button type="submit" name="status" value="">
					<span class="glyphicon glyphicon-dot with-right-margin white" aria-hidden="true"></span>
					Alle
				</button>
			</li>
			<li<?php if ($model->status == User::STATUS_ACTIVE) echo ' class="active"'; ?>>
				<button type="submit" name="status" value="<?= User::STATUS_ACTIVE; ?>">
					<span class="glyphicon glyphicon-dot with-right-margin green" aria-hidden="true"></span>
					<?= User::statusLabel(User::STATUS_ACTIVE) ?>
				</button>
			</li>
			<li<?php if ($model->status == User::STATUS_PENDING) echo ' class="active"'; ?>>
				<button type="submit" name="status" value="<?= User::STATUS_PENDING; ?>">
					<span class="glyphicon glyphicon-dot with-right-margin yellow" aria-hidden="true"></span>
					<?= User::statusLabel(User::STATUS_PENDING) ?>
				</button>
			</li>
			<li<?php if ($model->status == User::STATUS_SUSPENDED) echo ' class="active"'; ?>>
				<button type="submit" name="status" value="<?= User::STATUS_SUSPENDED; ?>">
					<span class="glyphicon glyphicon-dot with-right-margin red" aria-hidden="true"></span>
					<?= User::statusLabel(User::STATUS_SUSPENDED) ?>
				</button>
			</li>
			<li class="divider"></li>
			<li<?php if ($model->attribute == "first_name") echo ' class="active"'; ?>>
				<button type="submit" name="attribute" value="first_name">Vorname</button>
			</li>
			<li<?php if ($model->attribute == "last_name") echo ' class="active"'; ?>>
				<button type="submit" name="attribute" value="last_name">Nachname</button>
			</li>
			<li<?php if ($model->attribute == "email") echo ' class="active"'; ?>>
				<button type="submit" name="attribute" value="email">E-Mail</button>
			</li>
			<li<?php if ($model->attribute == "created_at") echo ' class="active"'; ?>>
				<button type="submit" name="attribute" value="created_at">Registriert seit</button>
			</li>
			<li class="divider"></li>
			<li<?php if ($model->order == "asc") echo ' class="active"'; ?>>
				<button type="submit" name="order" value="asc">Aufsteigend</button>
			</li>
			<li<?php if ($model->order == "desc") echo ' class="active"'; ?>>
				<button type="submit" name="order" value="desc">Absteigend</button>
			</li>
		</ul>
		</div>
		
		<?= Html::hiddenInput('status', $model->status) ?>
		<?= Html::hiddenInput('attribute', $model->attribute) ?>
		<?= Html::hiddenInput('order', $model->order) ?>
		<?= $form->field($model, 'search', ['template' => '{input}'])->textInput(['class' => 'form-control no-margin', 'placeholder' => 'Suchbegriff', 'pjax' => 0])->label(''); ?>
		<?= Html::submitButton('Suche', ['class' => 'hidden']) ?>
</div>
<?php ActiveForm::end(); ?>

<?php 
$this->registerJs( 
<<< EOT_JS_CODE
	$(document).on('keyup', '#user-search', function(event) {
		event.preventDefault();
		$.pjax.submit(event, '#users');
	});
EOT_JS_CODE
);
?>