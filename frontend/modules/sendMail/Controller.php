<?php

namespace frontend\modules\sendMail;

use Yii;
use frontend\modules\sendMail\models\Form;

class Controller extends \rs\web\FrontendController
{
    public function init() {
        parent::init();
        
        $this->setViewPath('@frontend/modules/sendMail/views');
    }
    
    public function actionIndex()
    {
        $model = new Form();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Deine Nachricht wurde erfolgreich gesendet.');
            } else {
                Yii::$app->session->setFlash('error', 'Deine Nachricht wurde nicht erfolgreich gesendet.');
            }
            return $this->refresh(); 
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }
}
