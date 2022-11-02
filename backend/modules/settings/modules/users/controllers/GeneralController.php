<?php

namespace backend\modules\settings\modules\users\controllers;

use yii\filters\AccessControl;

class GeneralController extends \yii\web\Controller
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
				'modelClass' => 'backend\modules\settings\modules\users\models\UserSettings',
				'viewName' => 'index',
			],
		];
	}
}
