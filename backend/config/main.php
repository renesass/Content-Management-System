<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

use \yii\web\Request;
$baseUrl = str_replace('/backend/web', '/backend', (new Request)->getBaseUrl());
$frontendBaseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
	'defaultRoute' => 'overview',
    'bootstrap' => ['log'],
    'modules' => [
	    'overview' => [
			'class' => 'backend\modules\overview\Overview',  
	    ],
	    'settings' => [
            'class' => 'backend\modules\settings\Settings',
        ],
	    'globals' => [
            'class' => 'backend\modules\globals\Globals',
        ],
        'users' => [
            'class' => 'backend\modules\users\Users',
        ],
        'pages' => [
            'class' => 'backend\modules\pages\Pages',
        ],
        'navigations' => [
            'class' => 'backend\modules\navigations\Navigations',
        ],
    ],
    'components' => [
        'request' => [
	        'baseUrl' => $baseUrl,
            'csrfParam' => '_csrf',
            'enableCsrfValidation' => false,
        ],
        'user' => [
	        'loginUrl' => ['site/login'],
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'class' => 'rs\web\User',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
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
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
		    'class' => 'yii\web\UrlManager',
		    'baseUrl' => $baseUrl,
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		    'rules' => [
			    // site
			    'login' => 'site/login',
			    'logout' => 'site/logout',
			    'request-password-reset' => 'site/request-password-reset',
                
                // settings
                'settings/users/groups/<action:>/<id:\d+>' => 'settings/users/groups/<action>',
                
                'settings/fields/groups/<action:>/<id:\d+>' => 'settings/fields/groups/<action>',
                'settings/fields/<action:>/<id:\d+>' => 'settings/fields/default/<action>',
                'settings/fields/<id:\d+>' => 'settings/fields',
                'settings/fields/<action:>' => 'settings/fields/default/<action>',
                
                'settings/globals/<action:>/<id:\d+>' => 'settings/globals/default/<action>',
                'settings/globals/<action:>' => 'settings/globals/default/<action>',
                
                'settings/extensions/register' => 'settings/extensions/default/register',
                'settings/extensions/deregister/<id:\d+>' => 'settings/extensions/default/deregister',
                
                // globals
                'globals/<name:>' => 'globals',
                
                // users
                'users/<action:>/<id:\d+>' => 'users/default/<action>',
                'users/<action:>' => 'users/default/<action>',
                
                // pages
                'pages/<action:>/<id:\d+>' => 'pages/default/<action>',
                'pages/<action:>' => 'pages/default/<action>',
                
                // navigations
			    'navigations/<action:>/<direction:>/<id:\d+>' => 'navigations/default/<action>',
                'navigations/<action:>/<id:\d+>' => 'navigations/default/<action>',
                'navigations/<action:>' => 'navigations/default/<action>',
		    ]
		],
		'urlManagerFrontend' => [
		    'class' => 'yii\web\UrlManager',
		    'baseUrl' => $frontendBaseUrl,
		    'enablePrettyUrl' => true,
		    'showScriptName' => false,
		],
    ],
    'params' => $params,
    'as beforeRequest' => [  // if guest user access site so, redirect to login page.
	    'class' => 'yii\filters\AccessControl',
	    'rules' => [
	        [
	            'actions' => ['login', 'logout', 'request-password-reset', 'error'],
	            'allow' => true,
	        ],
	        [
	            'allow' => true,
	            'roles' => ['admin', 'access'],
	        ],
	    ],
	    /*
	    'denyCallback' => function () {
	    }, */
	],
];
