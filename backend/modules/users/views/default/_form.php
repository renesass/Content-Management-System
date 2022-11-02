<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Tabs;
use rs\widgets\Permissions;
use rs\widgets\UserGroups;

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
				'label' => 'Profil',
				'options' => ['id' => 'profile'],
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
			    <?= $form->field($model, 'username')->textInput() ?>
				<?= $form->field($model, 'email')->textInput() ?>
				<?= $form->field($model, 'first_name')->textInput() ?>
				<?= $form->field($model, 'last_name')->textInput() ?>
				
				<?php
				if (Yii::$app->controller->action->id == 'new') {
					?>
					<?= $form->field($model, 'activation_manually')->checkbox() ?>
					<div id="set-password"<?php if ($model->activation_manually) echo ' class="no-display"'; ?>><?= $form->field($model, 'password')->passwordInput() ?></div>
					<?php
				}
				?>
				
		    </div>
		    <div id="profile" class="tab-pane">
			    <?php $profileModel->showFields($form); ?>
		    </div>
		    <div id="permissions" class="tab-pane">
			    <h4>Gruppen</h4>
			    <?= UserGroups::widget(['form' => $form, 'model' => $model]); ?>
			    
			    <h4>Rechte</h4>
			    <?= Permissions::widget(['form' => $form, 'model' => $model]); ?>
		    </div>
  		</div>
	    <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
	    <?php ActiveForm::end(); ?>
	</div>
</div>

<?php 
$this->registerJs( 
<<< EOT_JS_CODE
	$(document).ready(function(){
	    $('input#activation_manually').change(function(){
	        $('#set-password').toggle();
	    });
	});
EOT_JS_CODE
);