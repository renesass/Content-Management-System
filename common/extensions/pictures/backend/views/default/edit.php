<?php

$this->title = "Bild bearbeiten";

?>

<?= $this->render('_form', [
    'model' => $model,
    'extension' => $extension,
]) ?>
