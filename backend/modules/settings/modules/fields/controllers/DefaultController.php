<?php

namespace backend\modules\settings\modules\fields\controllers;

use Yii;
use backend\modules\settings\modules\fields\models\Field;
use backend\modules\settings\modules\fields\models\FieldGroup;
use backend\modules\settings\modules\globals\models\GlobalGroup;
use backend\modules\globals\models\GlobalVariable;
use backend\modules\users\models\UserProfile;
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

    public function actionIndex($id = null)
    {
	    if ($id !== null) {
		    if (FieldGroup::find()->where(['id' => $id])->exists() || $id == 0)
		    	$query = Field::find()->where(['group_id' => $id]);
		    else
		    	throw new \yii\web\NotFoundHttpException(Yii::t('yii', 'Page not found.'));
	    } else {
	    	$query = Field::find();
	    }
	    	
        $dataProvider = new ActiveDataProvider([
        	'query' => $query,
        	'sort' => false,
        ]);
        
        $groupDataProvider = new ActiveDataProvider([
            'query' => FieldGroup::find(),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'groupDataProvider' => $groupDataProvider,
        ]);
    }

    public function actionNew()
    {
	    $model = new Field();
	    
	    $types = [];
	    foreach (Yii::$app->fieldManager->getTypeModels() as $key => $typeModel) {
		    if (!class_exists($typeModel)) continue;
		    $types[$key] = new $typeModel;
	    }
	    $model->types = $types;
	    
	    if ($model->load(Yii::$app->request->post())) {
		    // load the model type if exists
		    $type = $types[$model->type] ?? null;
		    if (!empty($type)) $type->load(Yii::$app->request->post());
		    
		    if ($model->save()) {
	    		Yii::$app->session->setFlash('success', 'Das Feld wurde erfolgreich erstellt.');
				return $this->redirect(['/settings/fields', 'id' => $model->group_id]);
			}
	    }
	    
	    return $this->render('new', [
            'model' => $model,
        ]);
    }
    
    public function actionEdit($id)
    {
        $model = $this->findModel($id);
        
        $types = [];
	    foreach (Yii::$app->fieldManager->getTypeModels() as $key => $typeModel) {
		    if (!class_exists($typeModel)) continue;
		    $types[$key] = new $typeModel;
	    }
	    $model->types = $types;
	    
	    if ($model->load(Yii::$app->request->post())) {
		    // load the model type if exists
		    $type = $types[$model->type] ?? null;
		    if (!empty($type)) $type->load(Yii::$app->request->post());
		    
		    if ($model->save()) {
	    		Yii::$app->session->setFlash('success', 'Das Feld wurde erfolgreich bearbeitet.');
				return $this->redirect(['/settings/fields', 'id' => $model->group_id]);
			}
	    }
	    
	    return $this->render('edit', [
            'model' => $model,
        ]);
    }
   
    public function actionDelete($id, $section = null)
    {
        // delete field id from global group
        GlobalGroup::removeField($id);
        
        // delete all entries with field id from global
        GlobalVariable::deleteAll(['field_id' => $id]);
        
        // delete all entries with field id from user_profile
        UserProfile::deleteAll(['field_id' => $id]);
        
        // finally delete the field
	    $this->findModel($id)->delete();
	    
	    Yii::$app->session->setFlash('success', 'Das Feld wurde erfolgreich gelöscht.');
		return $this->redirect(['/settings/fields']);
    }

    protected function findModel($id)
    {
        if (($model = Field::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
