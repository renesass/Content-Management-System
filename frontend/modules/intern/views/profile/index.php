<?php

$this->title = "Profil bearbeiten";

?>

<h1><?=$this->title; ?></h1>

<?= $this->render('_form', [
	'model' => $model,
    'profileModel' => $profileModel,
]) ?>

