<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;

?>

<div class="alert alert-danger no-margin">
    <?= nl2br(Html::encode($message)) ?>
</div>
