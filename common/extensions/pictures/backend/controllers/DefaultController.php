<?php

namespace common\extensions\pictures\backend\controllers;

use Yii;
use common\extensions\pictures\common\models\Picture;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DefaultController extends \rs\web\BackendController
{
    public function actionIndex()
    {
	    $dataProvider = new ActiveDataProvider([
            'query' => Picture::find(),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionNew() 
    {
	    $model = new Picture();
		$model->scenario = 'new';
		
        if ($model->load(Yii::$app->request->post())) {
			$model->image = UploadedFile::getInstance($model, 'image');
			
	        if ($model->save()) {
	        	$model->image->saveAs($model->savePath($this->extension).'/'.$model->id.'.jpg');
	        	Yii::$app->session->setFlash('success', 'Das Bild wurde erfolgreich gespeichert.');
				return $this->refresh();
	        }
        }
        
        return $this->render('new', [
            'model' => $model,
            'extension' => $this->extension,
        ]);
    }
    
    public function actionEdit($id) 
    {
	    $model = $this->findModel($id);
	    
	    if ($model->load(Yii::$app->request->post())) {
			$model->image = UploadedFile::getInstance($model, 'image');
			
	        if ($model->save()) {
		        if (!empty($model->image)) {
			    	$model->image->saveAs($model->savePath($this->extension).'/'.$model->id.'.jpg');
		    	}
	        	
	        	Yii::$app->session->setFlash('success', 'Das Bild wurde erfolgreich bearbeitet.');
				return $this->refresh();
	        }
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
			
			Yii::$app->session->setFlash('success', 'Das Bild wurde erfolgreich gelöscht.');
			return $this->redirect(['/'.$this->extension->name]);
	    }
	}
    
    protected function findModel($id)
    {
        if (($model = Picture::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
