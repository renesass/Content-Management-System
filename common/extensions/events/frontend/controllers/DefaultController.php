<?php

namespace common\extensions\events\frontend\controllers;

use Yii;
use common\extensions\events\common\models\Event;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

use common\models\User;

class DefaultController extends \rs\web\FrontendController
{
    public function actionIndex() {
	    $dataProvider = new ActiveDataProvider([
            'query' => Event::find()->where(['>=', 'date_time', date('Y-m-d H:i:s')])->orderBy('date_time'),
            'sort' => false,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionDeregister() {
	    $request = Yii::$app->request->post();
	    $id = $request["id"];
	    $reason = $request["reason"];
	  
        $userId = Yii::$app->user->identity->id;
        if (($model = $this->findModel($id, true)) !== null) {
            $model->addDeregistration($userId, $reason);
            $model->save();
            
            // prepare for sending e-mail
	        $email = User::findIdentity(1)->email;
	        
	        $currentUser = Yii::$app->user->identity;
	        $event = $this->findModel($id);
	        $body = $currentUser->first_name.' '.$currentUser->last_name.' hat sich vom Termin am '.$event->getDate().' abgemeldet.';
	        if ($event->getDeregistrations()[$userId] != "") {
	        	$body .= ' Grund: '.$event->getDeregistrations()[$userId].'.';
	        }
            
            // send e-mail
            Yii::$app->mailer->compose()
            	->setTo($email)
				->setFrom([$currentUser->email => $currentUser->first_name.' '.$currentUser->last_name])
				->setSubject("Abmeldung")
				->setTextBody($body)
				->send();
				

			Yii::$app->session->setFlash('success', 'Du hast dich erfolgreich vom Termin abgemeldet.');
			Yii::$app->session->setFlash('warning', 'Hinweis: Bitte melde dich in Zukunft nur ab, wenn du wirklich nicht kannst. Jeder Probetermin ist sowohl für die eigene Sicherheit, als auch für das gemeinsame Singen wichtig! Durch deine Abmeldung verpasst du nicht nur viele musikalische Feinheiten, du lässt auch deine Stimmgruppe alleine!');
			return $this->redirect([$this->navigationItem->getPath()]);
	    }
    }
    
    public function actionRegister() {
	    $request = Yii::$app->request->post();
	    $id = $request["id"];
	    
        $userId = Yii::$app->user->identity->id;
        if (($model = $this->findModel($id, true)) !== null) {
            $model->removeDeregistration($userId);
            $model->save();
            
            // prepare for sending e-mail
            $email = User::findIdentity(1)->email;
            
	        $currentUser = Yii::$app->user->identity;
	        $event = $this->findModel($id);
	        $body = $currentUser->first_name.' '.$currentUser->last_name. ' hat sich zum Termin am '.$event->getDate().' angemeldet.';
            
            // send e-mail
            Yii::$app->mailer->compose()
            	->setTo($email)
				->setFrom([$currentUser->email => $currentUser->first_name.' '.$currentUser->last_name])
				->setSubject("Anmeldung")
				->setTextBody($body)
				->send();

			Yii::$app->session->setFlash('success', 'Du hast dich erfolgreich zum Termin angemeldet. Schön, dass du doch dabei bist!');
			return $this->redirect([$this->navigationItem->getPath()]);
	    }
    }
    
    /*
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
	} */
    
    protected function findModel($id, $deregistration = false) {
        if (!$deregistration) {
            $class = "\common\\extensions\\events\common\models\Event";
        } else {
            $class = "\common\\extensions\\events\common\models\EventDeregistration";
        }
        
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
