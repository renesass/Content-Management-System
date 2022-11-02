<?php

use yii\helpers\Html;
use rs\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = 'Administration';
$this->params['outside'] = '<div id="forgot-pw"><a href="'.Url::to(['../actions/users/request-password-changement']).'">Passwort vergessen</a></div>';

?>

<?php $form = ActiveForm::begin(['fieldConfig' => ['options' => ['tag' => false]]]); ?>

<?= $form->field($model, 'email')->textInput(['placeholder' => 'E-Mail', 'autofocus' => true, 'class' => 'form-control', 'style' => 'margin-bottom: 5px;'])->label(false)->error(false); ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Passwort', 'class' => 'form-control', 'style' => 'margin-bottom: 18px;'])->label(false)->error(false); ?>
<?= Html::submitButton('Anmelden', ['class' => 'btn btn-primary  btn-block']) ?>

<?php ActiveForm::end(); ?>