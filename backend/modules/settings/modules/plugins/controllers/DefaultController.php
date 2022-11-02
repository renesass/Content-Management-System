<?php

namespace backend\modules\settings\modules\plugins\controllers;

use Yii;
use backend\modules\settings\modules\plugins\models\Plugin;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
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
	                    'actions' => ['index', 'register', 'deregister'],
	                    'roles' => ['admin', 'settings'],
	                ],
	            ],
	        ],
	    ];
	}
	
    public function actionIndex()
    {
	    $dataProvider = new ActiveDataProvider([
            'query' => Plugin::find(),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRegister() 
    {
	    $model = new Plugin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        // install plugin
	        Yii::$app->pluginManager->install($model);
	        
	        Yii::$app->session->setFlash('success', 'Das Plugin wurde erfolgreich registriert.');
            return $this->redirect(['/settings/plugins']);
        }
        
        return $this->render('new', [
            'model' => $model,
        ]);
    }
    
    public function actionDeregister($id)
    {
	    if (($model = $this->findModel($id)) !== null) {
		    // uninstall plugin
		    Yii::$app->pluginManager->uninstall($model);
		    
		    // delete from database
			$model->delete();
			
			Yii::$app->session->setFlash('success', 'Das Plugin wurde erfolgreich deregistriert.');
			return $this->redirect(['/settings/plugins']);
	    }
	}
    
    protected function findModel($id)
    {
        if (($model = Plugin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
