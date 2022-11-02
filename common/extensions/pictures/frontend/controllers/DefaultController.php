<?php

namespace common\extensions\pictures\frontend\controllers;

use Yii;
use common\extensions\pictures\common\models\Picture;

class DefaultController extends \rs\web\FrontendController
{
    public function actionIndex() {
	    $models = Picture::find()->orderBy('date desc')->all();

        return $this->render('index', [
        	'pictures' => $models,
        	'extension' => $this->extension,
        ]);
    }
}
