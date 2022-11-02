<?php

namespace backend\modules\navigations\controllers;

use Yii;
use backend\modules\navigations\models\NavigationItem;
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
	                    'actions' => ['index', 'new', 'edit', 'delete', 'move'],
	                    'roles' => ['admin', 'navigations'],
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
        $items = NavigationItem::getHierarchyStructure();
        
        return $this->render('index', [
            'items' => $items,
        ]); 
    }
    
    public function actionMove($direction, $id) 
    {
        $requestedItem = NavigationItem::find()->where(['order' => $id])->one();
        $requestedOrder = $requestedItem->order;
        $query = NavigationItem::find()
            ->where(['!=', 'name', $requestedItem->name])
            ->andWhere(['parent' => $requestedItem->parent]);
            
        if ($direction == "up") {
            $query->andWhere(['<', 'order', $requestedOrder]);
        } else if ($direction == "down") {
            $query->andWhere(['>', 'order', $requestedOrder]);
        } else {
            return $this->redirect(['/navigations']);
        }
        
        $otherItems = $query->all();
        
        if (!empty($otherItems)) {
            if ($direction == "up") {
                $matchedItem = end($otherItems);
            } else if ($direction == "down") {
                $matchedItem = $otherItems[0];
            }
            $matchedItemOrder = $matchedItem->order;
            
            // avoid onstraint violation
            $matchedItem->order = 0;
            $matchedItem->save();
            
            // switch order numbers
            $requestedItem->order = $matchedItemOrder;
            $requestedItem->save();
            $matchedItem->order = $requestedOrder;
            $matchedItem->save();
        }
        
        return $this->redirect(['/navigations']);
    }

    public function actionNew()
    {
        $model = new NavigationItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->clearHome();
	    	Yii::$app->session->setFlash('success', 'Der Navigationspunkt wurde erfolgreich erstellt.');
            return $this->redirect(['/navigations']);
        } 
        
	    return $this->render('new', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->clearHome();
			Yii::$app->session->setFlash('success', 'Der Navigationspunkt wurde erfolgreich bearbeitet.');
            return $this->redirect(['/navigations']);
        } 
	    
	    return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
	    Yii::$app->session->setFlash('success', 'Der Navigationspunkt wurde erfolgreich gelöscht.');
        return $this->redirect(['/navigations']);
    }

    protected function findModel($id)
    {
        if (($model = NavigationItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
