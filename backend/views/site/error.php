<?php

use yii\helpers\Html;

$this->title = $name;
?>

<div class="panel panel-default">
	<div class="panel-body">
		<?= nl2br(Html::encode($message)) ?>
	</div>
</div>