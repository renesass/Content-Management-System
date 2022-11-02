<?php

namespace backend\modules\overview\controllers;

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
	                    'roles' => ['admin', 'overview'],
	                ],
	            ],
	        ],
	    ];
	}
	
    public function actionIndex()
    {
        return $this->render('index');
    }
}
