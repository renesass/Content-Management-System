<?php
return [
	'language' => 'de',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
	    'db' => [
		    'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=127.0.0.1;dbname=cms',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
	    ],
	    'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'renesass96@gmail.com',
                'password' => 'myywicviqysvfimr',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],
	    'authManager' => [
			'class' => 'rs\rbac\DbManager',  
            'defaultRoles' => ['admin'],
	    ],
	    'i18n' => [
	        'translations' => [
	            'yii' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	                'fileMap' => [
	                    'yii' => 'yii.php',
	                ],
	            ],
	            'app' => [
	                'class' => 'yii\i18n\PhpMessageSource',
	                'basePath' => '@common/messages',
	                'fileMap' => [
	                    'app' => 'app.php',
	                ],
	            ],
	        ],
	    ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'settingManager' => [
	        'class' => 'rs\settings\Manager',
        ],
        'globalManager' => [
	        'class' => 'rs\globals\Manager',
        ],
        'fieldManager' => [
	        'class' => 'rs\fields\Manager',
        ],
        'userManager' => [
			'class' => 'rs\users\Manager',  
	    ],
        'userGroupManager' => [
			'class' => 'rs\usergroups\Manager',  
	    ],
	    'extensions' => [
			'class' => 'rs\extensions\Manager',  
	    ],
        'replacer' => [
            'class' => 'rs\helpers\Replacer',
        ]
    ],
];
