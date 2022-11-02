<?php

namespace backend\modules\pages\controllers;

use Yii;
use backend\modules\pages\models\Page;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
	                    'actions' => ['index', 'new', 'edit', 'delete'],
	                    'roles' => ['admin', 'pages'],
	                ],
	            ],
	        ],
	        'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
	    ];
	}

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Page::find(),
        	'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNew()
    {
        $model = new Page();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    	Yii::$app->session->setFlash('success', 'Die Seite wurde erfolgreich erstellt.');
            return $this->redirect(['/pages']);
        } 
        
	    return $this->render('new', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', 'Die Seite wurde erfolgreich bearbeitet.');
            return $this->redirect(['/pages']);
        } 
	    
	    return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        // change in navigation here...
		
	    Yii::$app->session->setFlash('success', 'Die Seite wurde erfolgreich gelöscht.');
        return $this->redirect(['/pages']);
    }

    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
