<?php

namespace backend\modules\settings\modules\extensions\controllers;

use Yii;
use backend\modules\settings\modules\extensions\models\Extension;
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
            'query' => Extension::find(),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionRegister() 
    {
	    $model = new Extension();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        // install extensions
	        Yii::$app->extensions->install($model);
	        
	        Yii::$app->session->setFlash('success', 'Die Erweiterung wurde erfolgreich registriert.');
            return $this->redirect(['/settings/extensions']);
        }
        
        return $this->render('new', [
            'model' => $model,
        ]);
    }
    
    public function actionDeregister($id)
    {
	    if (($model = $this->findModel($id)) !== null) {
		    // uninstall extension
		    Yii::$app->extensions->uninstall($model);
		    
		    // delete from database
			$model->delete();
			
			Yii::$app->session->setFlash('success', 'Die Erweiterung wurde erfolgreich deregistriert.');
			return $this->redirect(['/settings/extensions']);
	    }
	}
    
    protected function findModel($id)
    {
        if (($model = Extension::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
