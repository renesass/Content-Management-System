<?php

namespace backend\modules\settings\modules\globals\controllers;

use Yii;
use backend\modules\settings\modules\globals\models\GlobalGroup;
use backend\modules\globals\models\GlobalVariable;
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
	                    'roles' => ['admin', 'settings'],
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
            'query' => GlobalGroup::find(),
        	'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNew()
    {
        $model = new GlobalGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	    	Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich erstellt.');
            return $this->redirect(['/settings/globals']);
        } 
        
	    return $this->render('new', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich bearbeitet.');
            return $this->redirect(['/settings/globals']);
        } 
	    
	    return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        GlobalVariable::deleteAll(['group_id' => $id]);
		
	    Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich gelöscht.');
        return $this->redirect(['/settings/globals']);
    }

    protected function findModel($id)
    {
        if (($model = GlobalGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
