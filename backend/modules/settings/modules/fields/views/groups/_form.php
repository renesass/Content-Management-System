<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
<?= Html::submitButton($model->isNewRecord ? 'Erstellen' : 'Umbenennen', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>


