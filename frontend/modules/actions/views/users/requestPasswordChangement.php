<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Passwortänderung anfordern';

?>

<p>Bitte gebe deine E-Mail-Adresse an.<br>Ein Link zum Ändern des Passworts wird an diese E-Mail-Adresse gesendet.</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'email')->textInput(['placeholder' => 'E-Mail-Adresse', 'autofocus' => true, 'class' => 'form-control'])->label(false); ?>
<?= Html::submitButton('Anfordern', ['class' => 'btn btn-primary btn-block']) ?>

<?php ActiveForm::end(); ?>