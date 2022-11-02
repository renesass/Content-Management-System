<?php

namespace frontend\modules\actions\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use frontend\modules\actions\models\users\SetPasswordForm;
use frontend\modules\actions\models\users\RequestPasswordChangementForm;
use common\models\User;

class UsersController extends \yii\web\Controller
{
	public $layout = "@common/views/layouts/external";
	
	public $messages = [
		// includes passive and active
		'activation' => [
			'title' => 'Benutzer aktivieren',
			'flash' => 'Der Benutzer wurde erfolgreich aktiviert.',
		],
		'resetPassword' => [
			'title' => 'Passwort ändern',
			'flash' => 'Das Passwort wurde erfolgreich geändert.',
		],
		'verifyEmail' => [
			'flash' => 'Die E-Mail wurde erfolgreich verifiziert.',
		],
		'error' => 'Der aufgerufene Token existiert nicht oder ist nicht mehr gültig.',
	];
	
	public function actionRequestPasswordChangement()
    {
        $model = new RequestPasswordChangementForm();
        
        if ($model->load(Yii::$app->request->post())) {
	        if ($model->validate()) {
		        // this user must exists, because it's already validated
		        $user = User::find()->where(['email' => $model->email])->one();
		        
		        // send email
	            if ($user->sendPasswordChangement()) {
	                Yii::$app->session->setFlash('success', 'Die E-Mail wurde erfolgreich gesendet. Bitte überprüfe die E-Mail für weitere Anweisungen.');
	                
	                return $this->goHome();
	            } else {
	                Yii::$app->session->setFlash('error', 'Die E-Mail konnte nicht gesendet werden.');
	            }
	        } else {
		        $model->email = (string) null;
		        Yii::$app->session->setFlash('danger', 'Es konnte kein gültiger Benutzer mit dieser E-Mail-Adresse gefunden werden.');
	        }
        }
		
		$this->layout = "@common/views/layouts/external";
        return $this->render('requestPasswordChangement', [
            'model' => $model,
        ]);
    }
	
	public function actionSetPassword($token)
    {
        try {
            $user = $this->validPasswordToken($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $model = new SetPasswordForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
	        $wasPassivelyRegistered = $user->wasPassivelyRegistered();
	        if ($model->setPassword()) {
		        if ($wasPassivelyRegistered) {
			        Yii::$app->session->setFlash('success', 'Dein Benutzer wurde erfolgreich aktiviert.');
		        } else {
			        Yii::$app->session->setFlash('success', 'Das Passwort wurde erfolgreich geändert.');
		        }
	        }

            return $this->redirect(['/login']);
        }

        return $this->render('setPassword', [
            'model' => $model,
        ]);
    }
    
    public function actionActivate($token)
    {
	    try {
		    $user = $this->validActivationToken($token);
	    } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        // has been passively registered
        if ($user->wasPassivelyRegistered()) {
	        return $this->redirect(['/actions/users/set-password', 'token' => $user->password_token]);
        } 
	        
	        
	    $user->setActive();
	    $user->save();
	    
	    Yii::$app->session->setFlash('success', 'Dein Benutzer wurde erfolgreich aktiviert.');

		return $this->goHome(); 
    }
    
    public function actionVerify($token) 
    {
	    try {
		    $user = $this->validVerificationToken($token);
	    } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        $user->confirmEmail();
		$user->save();
		
		Yii::$app->session->setFlash('success', 'Deine neue E-Mail-Adresse wurde erfolgreich geändert.');

		return $this->goHome(); 
	}
	
	
	protected function validPasswordToken($token)
	{
		if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token darf nicht leer sein.');
        }
        
        $user = User::findByPasswordToken($token);
        if (!$user) {
            throw new InvalidParamException('Kein gültiger Token.');
        } else if (!($user->canChangePassword() || $user->isPending())) {
	        throw new ForbiddenHttpException();
		}
        
        return $user;
	}
	
	protected function validActivationToken($token)
	{
		if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token darf nicht leer sein.');
        }
        
        $user = User::findByActivationToken($token);
        if (!$user) {
            throw new InvalidParamException('Kein gültiger Token.');
        } else if (!($user->isPending())) {
	        throw new ForbiddenHttpException();
		}
        
        return $user;
	}
	
	protected function validVerificationToken($token)
	{
		if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Token darf nicht leer sein.');
        }
        
        $user = User::findByVerificationToken($token);
        if (!$user) {
            throw new InvalidParamException('Kein gültiger Token.');
        } else if (!($user->hasUnconfirmedEmail())) {
	        throw new ForbiddenHttpException();
		}
        
        return $user;
	}	
}