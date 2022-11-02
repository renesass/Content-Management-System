<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;

?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'group')->dropDownList($model->listGroups()) ?>
<?= $form->field($model, 'subject')->textInput() ?>
<?= $form->field($model, 'body')->textarea(['rows' => '8']) ?>
<?= Html::submitButton('Senden', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>