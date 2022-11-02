<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Anmelden';
$this->params['breadcrumbs'][] = $this->title;

?>

<p>Bitte fülle folgende Felder aus, um dich anzumelden:</p>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
<?= $form->field($model, 'password')->passwordInput() ?>
<div style="color: #999; margin-bottom: 18px;">
    Wenn du dein Passwort vergessen hast, kannst du es <?= Html::a('hier zurücksetzen <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>', ['/actions/users/request-password-changement'], ['target'=>'_blank']) ?>.
</div>
<?= Html::submitButton('Anmelden', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>