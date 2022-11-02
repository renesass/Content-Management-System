<?php
	
use yii\helpers\Html;

$this->title = 'Benutzer erstellen';
$this->params['breadcrumbs'][] = ['label' => 'Benutzer', 'url' => ['/users']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?= $this->render('_form', [
	'model' => $model,
    'profileModel' => $profileModel,
]) ?>
