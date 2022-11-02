<?php

namespace frontend\modules\editProfile;

use Yii;
use frontend\modules\editProfile\models\User;
use backend\modules\users\models\DynamicUserProfile;

class Controller extends \rs\web\FrontendController
{	
    public function init() {
        parent::init();
        
        $this->setViewPath('@frontend/modules/editProfile/views');
    }
 
    public function actionIndex()
    {
	    $id = Yii::$app->user->identity->id;
	    $model = $this->findModel($id);
	    $profileModel = new DynamicUserProfile(explode(", ", Yii::$app->settingManager->get('user', 'field_ids')), $id);
	    $profileModel->load(Yii::$app->request->post());
	    
	    if ($model->load(Yii::$app->request->post())) {
		    if ($model->save() && $profileModel->save()) {
	        	Yii::$app->getSession()->setFlash('success', 'Das Profil wurde erfolgreich bearbeitet.');
            	return $this->refresh();  
		    } else {
                Yii::$app->getSession()->setFlash('danger', 'Bitte überprüfe deine Eingaben.');
            }
	    }
	    
	    return $this->render('index', [
		    'model' => $model,
		    'profileModel' => $profileModel,
	    ]);
    }
    
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
