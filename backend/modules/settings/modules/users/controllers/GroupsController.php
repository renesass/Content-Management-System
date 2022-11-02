<?php

namespace backend\modules\settings\modules\users\controllers;

use Yii;
use backend\modules\settings\modules\users\models\Group;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class GroupsController extends \yii\web\Controller
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
	    ];
	}
	
    public function actionIndex()
    {
	    $dataProvider = new ActiveDataProvider([
            'query' => Group::find(),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionNew() 
    {
	    $model = new Group();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich erstellt.');
            return $this->redirect(['/settings/users/groups']);
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
        }
	        
        return $this->render('edit', [
            'model' => $model,
        ]);
    }
    
    public function actionDelete($id)
    {
	    if (($model = Group::findOne($id)) !== null) {
			$model->delete();
			Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich gelöscht.');
			
			// delete group ids from users here
			User::deleteGroupId($id);
			
			return $this->redirect(['/settings/users/groups']);
	    } else {
		    throw new NotFoundHttpException('The requested page does not exist.');
	    }
	}
    
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
