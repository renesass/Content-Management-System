<?php

namespace backend\modules\settings\modules\general\controllers;

use yii\filters\AccessControl;

class DefaultController extends \yii\web\Controller
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
				'modelClass' => 'backend\modules\settings\modules\general\models\GeneralSettings',
				'viewName' => 'index',
			],
		];
	}
}
