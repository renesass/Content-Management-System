<?php
	
return [
	'urlManager' => [
		'rules' => [
			'settings/{name}/<action:\w+>/<id:\d+>' => 'settings/{name}/default/<action>',
			'settings/{name}/<action:\w+>' => 'settings/{name}/default/<action>',
	    ],
	],
	'icon' => 'glyphicon glyphicon-calendar',
];
	
?>