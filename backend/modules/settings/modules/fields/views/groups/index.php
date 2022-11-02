<?php

use yii\helpers\Html;
use rs\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use backend\modules\settings\modules\fields\models\FieldGroup;

/* popup for new group */
Modal::begin([
	'header' => '<h4>Neue Gruppe erstellen</h4>',
	'id' => 'new-group',
	'size' => 'modal-sm',
]);
echo '<div id="new-group-content"></div>';
Modal::end();

/* popup for edit group */
Modal::begin([
	'header' => '<h4>Gruppe umbenennen</h4>',
	'id' => 'edit-group',
	'size' => 'modal-sm',
]);
echo '<div id="edit-group-content"></div>';
Modal::end();

$id = Yii::$app->request->get('id');
if (!isset($id)) {
	$currentGroupLabel = "Alle Gruppen";
}
else if ($id == '0') {
	$currentGroupLabel = "Keiner Gruppe zugewiesen";
}
else {
	$currentGroupLabel = FieldGroup::findOne($id)->label;
}

?>

<div class="panel panel-default">
	<button type="button" class="show-sub-area" for="field-groups"><span class="glyphicon glyphicon-menu-down pull-right" aria-hidden="true"></span><?= $currentGroupLabel; ?></button>
	<div class="sub-area" id="field-groups">
		<ul class="sub-navigation">
			<li<?php if (!isset($id)) echo ' class="active"'; ?>><a href="<?= Url::to(['/settings/fields']); ?>">Alle Gruppen</a></li>
			<li<?php if ($id == '0') echo ' class="active"'; ?>><a href="<?= Url::to(['/settings/fields', 'id' => 0]); ?>">Keiner Gruppe zugewiesen</a></li>
			<?php 
			$rows = $dataProvider->getModels();
			foreach ($rows as $row) {
				if ($row['id'] == $id) {
					echo '<li class="active"><a href="'.Url::to(['/settings/fields', 'id' => $row['id']]).'">'.$row['label'].'</a></li>';
				} else {
					echo '<li><a href="'.Url::to(['/settings/fields', 'id' => $row['id']]).'">'.$row['label'].'</a></li>';
				}
			} ?>
		</ul>
		<div class="btn-group padding" role="group">
			<?= Html::button('Neue Gruppe', ['value' => Url::to(['/settings/fields/groups/new']), 'class' => 'btn btn-primary', 'id' => 'new-group-button']); ?>
			<?php if (isset($id) && $id != 0) { ?>
			<div class="btn-group" role="group">
		    	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
		    		
		    		Einstellungen
		    		<span class="caret"></span>
		    	</button>
				<ul class="dropdown-menu">
					<li><?= Html::button('Ausgewählte Gruppe<br>umbenennen', ['value' => Url::to(['/settings/fields/groups/rename', 'id' => $id]), 'id' => 'edit-group-button']); ?>
</li>
					<li><a href="<?= Url::to(['/settings/fields/groups/delete', 'id' => $id]) ?>" title="löschen" aria-label="löschen" data-pjax="0" data-confirm='Willst du diese Gruppe wirklich löschen? Felder die in dieser Gruppe sind, werden nicht gelöscht, sondern der Gruppe "Keiner Gruppe zugewiesen" zugewiesen.' data-method="post">Ausgewählte Gruppe<br>löschen</a></li>
		    	</ul>
			</div>
			<?php } ?>
		</div>
	</div>
</div>