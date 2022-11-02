<?php

namespace backend\modules\settings\modules\email\controllers;

use yii\filters\AccessControl;

class MessagesController extends \yii\web\Controller
{
	public function behaviors()
	{
	    return [
	        'access' => [
	            'class' => AccessControl::className(),
	            'rules' => [
	                [
	                    'allow' => true,
	                    'actions' => ['index'],
	                    'roles' => ['admin', 'settings'],
	                ],
	            ],
	        ],
	    ];
	}
	
	public function actions() 
	{
		return [
			'index' => [
				'class' => 'rs\settings\Action',
				'modelClass' => 'backend\modules\settings\modules\email\models\EmailMessageSettings',
				'viewName' => 'index',
			],
		];
	}
}
