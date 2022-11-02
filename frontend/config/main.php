<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'frontend', // do not edit this entry
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    // 'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'actions' => [
            'class' => 'frontend\basics\actions\Actions',
        ],
        'site' => [
            'class' => 'frontend\basics\site\Site',
        ],
        'blub' => [
            'class' => 'frontend\modules\intern\Intern',
        ],
        /*
        'intern' => [
            'class' => 'frontend\modules\intern\Intern',
        ], */
        
        
        // plugins 
        /* 'pictures' => [
	        'class' => 'common\plugins\pictures\frontend\Pictures',
        ], */
    ],
    'components' => [
        'request' => [
	        'baseUrl' => $baseUrl,
            'csrfParam' => '_csrf',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'class' => 'rs\web\User',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'data',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/default/error',
        ],
        'urlManager' => [
		    'class' => 'yii\web\UrlManager',
		    'baseUrl' => $baseUrl,
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		    'rules' => [
			    'actions/users/reset-password/<token:>' => 'actions/users/reset-password',
			    'actions/users/activate/<token:>' => 'actions/users/activate',
			    'actions/users/verify/<token:>' => 'actions/users/verify',
			    
			    
			    
			    // intern
			    'intern' => 'intern/default/index',
			    'intern/profile' => 'intern/profile/index',
			    
			    // plugins
			    'pictures' => 'pictures/default/index',
			    
			    // main
			    'login' => 'site/default/login',
			    'logout' => 'site/default/logout',
			]
		],
		'urlManagerBackend' => [
		    'class' => 'yii\web\UrlManager',
		    'baseUrl' => '/backend',
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		],
    ],
    'params' => $params,
];
