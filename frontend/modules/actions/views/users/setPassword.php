<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Passwort festlegen';

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'Passwort'])->label(false) ?>
<?= Html::submitButton('Speichern', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>
