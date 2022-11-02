<?php

namespace common\extensions\events\backend\controllers;

use Yii;
use common\extensions\events\common\models\Event;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class DefaultController extends \rs\web\BackendController
{
    public function actionIndex()
    {
	    $dataProviderFuture = new ActiveDataProvider([
            'query' => Event::find()->where(['>=', 'date_time', date('Y-m-d H:i:s')])->orderBy('date_time'),
            'sort' => false,
        ]);
        
        $dataProviderPast = new ActiveDataProvider([
            'query' => Event::find()->where(['<', 'date_time', date('Y-m-d H:i:s')])->orderBy('date_time'),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProviderFuture' => $dataProviderFuture,
            'dataProviderPast' => $dataProviderPast,
        ]);
    }
    
    public function actionNew() 
    {
	    $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        Yii::$app->session->setFlash('success', 'Der Termin wurde erfolgreich erstellt.');
            return $this->refresh();
        }
        
        return $this->render('new', [
            'model' => $model,
            'extension' => $this->extension,
        ]);
    }
    
    public function actionEdit($id) 
    {
	    $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Der Termin wurde erfolgreich bearbeitet.');
            return $this->refresh();
        }
	        
        return $this->render('edit', [
            'model' => $model,
            'extension' => $this->extension,
        ]);
    }
    
    public function actionDelete($id)
    {
	    if (($model = $this->findModel($id)) !== null) {
			$model->delete();
			
			Yii::$app->session->setFlash('success', 'Der Termin wurde erfolgreich gelöscht.');
			return $this->redirect(['/'.$this->extension->name]);
	    }
	}
    
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
