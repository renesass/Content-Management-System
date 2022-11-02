<?php
	
use yii\helpers\Html;
use rs\helpers\Replacer;

$link = '<a href="'.$token.'" class="btn">'.$label.'</a>';

$replacements = [
	'site_name' => Yii::$app->settingManager->get('general', 'site_name'),
	'username' => $user->username,
	'first_name' => $user->first_name,
	'link' => $link, 
];

echo Html::encode(Replacer::replace(Yii::$app->settingManager->get('email_message', $section.'_message'), $replacements));

?>