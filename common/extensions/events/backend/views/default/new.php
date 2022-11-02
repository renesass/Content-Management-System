<?php

$this->title = 'Neuer Termin';

?>

<?= $this->render('_form', [
    'model' => $model,
    'extension' => $extension,
]) ?>
