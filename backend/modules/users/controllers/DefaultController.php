<?php

namespace backend\modules\users\controllers;

use Yii;
use backend\modules\users\models\User;
use backend\modules\users\models\UserSearch;
use backend\modules\users\models\NewUserForm;
use backend\modules\users\models\EditUserForm;
use backend\modules\users\models\DynamicUserProfile;
use backend\models\AuthItem;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class DefaultController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'send-registration' => ['POST'],
                    'sendresetpasswordmailasdfasdf' => ['POST'],
                ],
            ],
            'access' => [
	            'class' => AccessControl::className(),
	            'rules' => [
	                [
	                    'allow' => true,
	                    'actions' => ['index'],
	                    'roles' => ['admin', 'users'],
	                ],
	                [
	                    'allow' => true,
	                    'actions' => ['new', 'send-user-activation'],
	                    'roles' => ['admin', 'createUser'],
	                ],
	                [
	                    'allow' => true,
	                    'actions' => ['edit', 'unsuspend', 'suspend', 'send-password-changement', 'send-email-verification'],
	                    'roles' => ['admin', 'editUser'],
	                ],
	                [
	                    'allow' => true,
	                    'actions' => ['delete'],
	                    'roles' => ['admin', 'deleteUser'],
	                ],
	            ],
	        ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->post());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNew()
    {    	        	
	    $model = new User();
	    $profileModel = new DynamicUserProfile(explode(", ", Yii::$app->settingManager->get('user', 'field_ids')));
	    
	    if ($model->load(Yii::$app->request->post()) && $profileModel->load(Yii::$app->request->post())) {
		    if ($model->save() && $profileModel->setSubAreaId($model->id) && $profileModel->save()) {
			    Yii::$app->session->addFlash('success', 'Der Benutzer wurde erfolgreich erstellt.');
			    
			    // send email to user
	        	if ($model->activation_manually) {
		        	if ($model->sendPassiveUserActivation()) {
			        	 Yii::$app->session->addFlash('success', 'Die E-Mail zum Setzen des Passworts wurde erfolgreich gesendet.');
		        	} else {
			        	 Yii::$app->session->addFlash('danger', 'Die E-Mail zum Setzen des Passworts konnte nicht gesendet werden.');
		        	}
	        	}
	        	
            	return $this->redirect(['/users']);
		    }
	    }
	    
	    return $this->render('new', [
		    'model' => $model,
		    'profileModel' => $profileModel,
	    ]);
    }

    public function actionEdit($id)
    {
	    $model = $this->findModel($id);
	    $profileModel = new DynamicUserProfile(explode(", ", Yii::$app->settingManager->get('user', 'field_ids')), $id);
	    $profileModel->load(Yii::$app->request->post());
	    
	    if ($model->load(Yii::$app->request->post())) {
		    if ($model->save() && $profileModel->save()) {
	        	Yii::$app->getSession()->setFlash('success', 'Der Benutzer wurde erfolgreich bearbeitet.');
            	return $this->redirect(['/users/edit', 'id' => $id]);  
		    }
	    }
	    
	    return $this->render('edit', [
		    'model' => $model,
		    'profileModel' => $profileModel,
	    ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        
        // delete user group assignments
        Yii::$app->userGroupManager->removeAssignmentsByUser($id);
        
        // delete all entries
        DynamicUserProfile::deleteAssignments($id);

        return $this->redirect(['index']);
    }
    
    public function actionSuspend($id)
    {
	    $user = $this->findModel($id);
	    $user->suspend();
	   
	    return $this->redirect(['/users/edit', 'id' => $user->id]);
    }

    public function actionUnsuspend($id)
    {
	    $user = $this->findModel($id);
	    $user->unsuspend();
	    
	    return $this->redirect(['/users/edit', 'id' => $user->id]);
    }
    
    
    public function actionSendPasswordChangement($id) {
	    $user = $this->findModel($id);
	    
	    if ($user->canChangePassword()) {
		    if ($user->sendPasswordChangement()) {
	        	Yii::$app->getSession()->setFlash('success', 'Die E-Mail zur Passwortänderung wurde erfolgreich gesendet.');
		    } else {
	        	Yii::$app->getSession()->setFlash('danger', 'Die E-Mail zur Passwortänderung konnte nicht gesendet werden.');
		    }
	    }
	    
	    return $this->redirect(['/users/edit', 'id' => $user->id]);
    } 
    
    public function actionSendUserActivation($id) {
	    $user = $this->findModel($id);
	    $sent = false;
	    
	    // decide passive or active
	    if ($user->isPending()) {
		    // passive
		    if (!$user->hasPassword()) {
			    if ($user->sendPassiveUserActivation()) $sent = true;
		    } 
		    // active
		    else {
			    if ($user->sendActiveUserActivation()) $sent = true;
		    }
		    
		    if ($sent) {
			    Yii::$app->getSession()->setFlash('success', 'Die E-Mail zur Benutzeraktivierung wurde erfolgreich gesendet.');
		    } else {
			    Yii::$app->getSession()->setFlash('danger', 'Die E-Mail zur Benutzeraktivierung konnte nicht gesendet werden.');
		    }
	    }
	    
	    return $this->redirect(['/users/edit', 'id' => $user->id]);
    }
    
    public function actionSendEmailVerification($id) {
	     $user = $this->findModel($id);
	    
	    if ($user->hasUnconfirmedEmail()) {
		    if ($user->sendEmailVerification()) {
	        	Yii::$app->getSession()->setFlash('success', 'Die E-Mail zur E-Mail-Überprüfung wurde erfolgreich gesendet.');
		    } else {
	        	Yii::$app->getSession()->setFlash('danger', 'Die E-Mail zur E-Mail-Überprüfung konnte nicht gesendet werden.');
		    }
	    }
	    
	    return $this->redirect(['/users/edit', 'id' => $user->id]);
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
