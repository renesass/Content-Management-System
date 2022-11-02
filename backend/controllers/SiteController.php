<?php
	
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\PasswordResetRequestForm;

class SiteController extends Controller
{
    public function actionError()
	{
		if (Yii::$app->user->can('admin') || Yii::$app->user->can('access')) {
	    	$this->layout = "@backend/views/layouts/main";
	    	$view = 'error';
	    } else {
	    	$this->layout = "@common/views/layouts/external";
			$view = 'externalError';
	    }
	    
	    $exception = Yii::$app->errorHandler->exception;
	    $name = $exception->getName();
	    $message = $exception->getMessage();
	    if ($exception !== null) {
	        return $this->render($view, ['name' => $name, 'message' => $message]);
	    }
	}

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
	        if ($model->login()) {
		        return $this->goHome();
		    } else {
			    if (!empty($model->getErrors('suspended'))) {
			    	Yii::$app->getSession()->setFlash('danger', $model->getErrors('suspended'));
			    } else {
			    	Yii::$app->getSession()->setFlash('danger', $model->getErrors('password'));
			    }
		    }
        } 
        
        $this->layout = "@common/views/layouts/external";
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
