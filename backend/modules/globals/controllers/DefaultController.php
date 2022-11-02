<?php

namespace backend\modules\globals\controllers;

use Yii;
use common\models\DynamicModel;
use backend\modules\settings\modules\globals\models\GlobalGroup;
use backend\modules\globals\models\DynamicGlobalVariable;
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
	                    'actions' => ['index'],
	                    'roles' => ['admin', 'globals'],
	                ],
	            ],
	        ],
	    ];
	}
	
    public function actionIndex($name = null)
    {
	    if (empty($name)) {
			if (empty($group = GlobalGroup::find()->one())) {
				Yii::$app->getSession()->setFlash('info', 'Es sind keine Gruppe vorhanden.');
				return $this->render('blank');
			}
			$name = $group->name;
	    } else {
	    	$group = $this->findModel($name);
	    }
	    
	    $model = new DynamicGlobalVariable($group->field_ids, $group->id);
	    
	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    Yii::$app->getSession()->setFlash('success', 'Die globalen Variablen wurden erfolgreich gespeichert.');
	    }
	    
	    return $this->render('index', [
		    'name' => $name,
	    	'model' => $model, 
	    	'groups' => GlobalGroup::find()->all()
	    ]);
	}
	
	protected function findModel($name)
    {
        if (($model = GlobalGroup::find()->where(['name' => $name])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
