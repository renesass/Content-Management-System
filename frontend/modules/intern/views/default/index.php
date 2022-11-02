<?php
	
$this->title = 'Übersicht';
$this->params['sidebarNavigation'][] = $this->title;

?>

<h1>Übersicht</h1>
<p>Herzlich Willkommen <?= Yii::$app->user->identity->first_name ?>. Schön, dass du hier bist!</p>
