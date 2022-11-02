<?php

$this->title = 'Neues Bild';

?>

<?= $this->render('_form', [
    'model' => $model,
    'extension' => $extension,
]) ?>
