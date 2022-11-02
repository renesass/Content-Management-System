<?php

namespace backend\modules\settings\modules\fields\controllers;

use Yii;
use backend\modules\settings\modules\fields\models\Field;
use backend\modules\settings\modules\fields\models\FieldGroup;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
	                    'actions' => ['new', 'rename', 'delete'],
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

    public function actionNew()
    {
	    $model = new FieldGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich erstellt.');
            return $this->redirect(['/settings/fields', 'id' => $model->id]);
        }
        
        return $this->renderAjax('new', [
            'model' => $model,
        ]);
    }
    
    public function actionRename($id)
    {
	    $model = $this->findModel($id);
		    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
	        Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich umbenannt.');
            return $this->redirect(['/settings/fields', 'id' => $model->id]);
        } else {
            return $this->renderAjax('rename', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
	    $model = $this->findModel($id)->delete();
	    
	    // give fields with the group_id $id the new group_id 0
	    $fields = Field::find()->where(['group_id' => $id])->all();
	    foreach ($fields as $field) {
		    $field->group_id = 0;
		    $field->save();
	    }
	    
	    Yii::$app->session->setFlash('success', 'Die Gruppe wurde erfolgreich gelöscht.');
		return $this->redirect(['/settings/fields']);
    }

    protected function findModel($id)
    {
        if (($model = FieldGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
