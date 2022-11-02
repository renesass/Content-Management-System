<?php

use yii\helpers\Html;
use rs\helpers\Replacer;

$replacements = [
    'user' => $user,
	'link' => $link,   
];echo Html::encode(Replacer::replace(Yii::$app->settingManager->get('email_message', $section.'_message'), $replacements));

?>