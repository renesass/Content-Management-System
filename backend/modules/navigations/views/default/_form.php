<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use rs\widgets\ActiveForm;
use backend\modules\navigations\models\NavigationItem;
use backend\modules\pages\models\Page;
use yii\bootstrap\Tabs;
use rs\web\Sidebar;
use rs\widgets\UserGroups;

$this->params['breadcrumbs'][] = ['label' => 'Navigationen', 'url' => ['/navigations']];
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
				'label' => 'Seitenleiste',
				'options' => ['id' => 'sidebar2'],
			],
			[
				'label' => 'Zugriff',
				'options' => ['id' => 'access'],
			],
		],
	]);	?>

	<div class="panel-body">
	    <?php $form = ActiveForm::begin(); ?>
	    <div class="tab-content">
		    <div id="general" class="tab-pane active">
				<?= $form->field($model, 'label'); ?>
                <?= $form->field($model, 'name')->textInput(['class' => 'form-control name']); ?>
                <?php 
                if ($this->context->action->id == "edit") {
                    $list = NavigationItem::list(true, $model);
                } else {
                    $list = NavigationItem::list();
                }
                ?>
                <?= $form->field($model, 'parent')->dropDownList($list); ?>
                <?= $form->field($model, 'home')->checkbox(); ?>
                <?= $form->field($model, 'content_type')->dropDownList(NavigationItem::DEFAULT_CONTENT_TYPES); ?>
                <div class="content_type<?php if ($model->content_type != "page" && !empty($model->content_type)) echo ' no-display'; ?>" id="content-type-page"><?= $form->field($model, 'page')->dropDownList(ArrayHelper::map(Page::find()->all(), 'id', 'label')); ?></div>
                <div class="content_type<?php if ($model->content_type != "module") echo ' no-display'; ?>" id="content-type-module"><?= $form->field($model, 'module')->dropDownList($model::listModules()); ?></div>
                <div class="content_type<?php if ($model->content_type != "extension") echo ' no-display'; ?>" id="content-type-extension"><?= $form->field($model, 'extension')->dropDownList($model::listExtensions()); ?></div>
                <div class="content_type<?php if ($model->content_type != "forwarding") echo ' no-display'; ?>" id="content-type-forwarding"><?= $form->field($model, 'forwarding'); ?></div>
		    </div>
            
		    <div id="sidebar2" class="tab-pane">
                <?= $form->field($model, 'sidebar')->checkbox(); ?>
                 <div id="templates"<?php if (!$model->sidebar) echo ' class="no-display"'; ?>>
                    <?= $form->field($model, 'sidebar_template')->dropDownList($model::listTemplates()); ?>
                </div>
		    </div>
            
		    <div id="access" class="tab-pane">
			    <?= $form->field($model, 'user_only')->checkbox(); ?>
                <div id="groups"<?php if (!$model->user_only) echo ' class="no-display"'; ?>>
                    <h4>Beschränkung auf Gruppen</h4>
                    <?= UserGroups::widget(['form' => $form, 'model' => $model]); ?>
                </div>
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
	    $('input#user_only').change(function() {
	        $('#groups').toggle();
	    });
        
        $('#content_type').change(function() {
	        $('.content_type').hide();
            $('#content-type-' + ($(this).val())).show();
	    });
        
        $('input#sidebar').change(function() {
	        $('#templates').toggle();
	    });
	});
EOT_JS_CODE
);