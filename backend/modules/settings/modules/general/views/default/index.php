<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use rs\web\Sidebar;

$this->title = 'Allgemeines';
$this->params['breadcrumbs'][] = ['label' => 'Einstellungen', 'url' => ['/settings']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-default">
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'site_name'); ?>
        <?= $form->field($model, 'title'); ?>
        <?= $form->field($model, 'description')->textArea(['rows' => 4]); ?>
        <?= $form->field($model, 'sidebar')->checkbox(); ?>
        <div id="templates"<?php if (!$model->sidebar) echo ' class="no-display"'; ?>>
            <?= $form->field($model, 'sidebar_template')->dropDownList(\backend\modules\navigations\models\NavigationItem::listTemplates()); ?>
        </div>
        <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>

<?php 
$this->registerJs( 
<<< EOT_JS_CODE
	$(document).ready(function() {
        $('input#sidebar').change(function(){
	        $('#templates').toggle();
	    });
	});
EOT_JS_CODE
);