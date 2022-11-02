<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Passwortzurücksetzung anfordern';
$this->params['breadcrumbs'][] = $this->title;

?>

<h1><?= Html::encode($this->title) ?></h1>

<p>Bitte gebe deine E-Mail-Adresse an. Ein Link zum Zurücksetzen des Passwortes wird an diese E-Mail-Adresse gesendet.</p>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
        
        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
        <?= Html::submitButton('Passwortzurücksetzung anfordern', ['class' => 'btn btn-primary']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>