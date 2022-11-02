<?php

namespace frontend\modules\intern\controllers;

class DefaultController extends \yii\web\Controller
{
	public $sidebar;
	
	public function init() {
        parent::init();
        
        $this->layout = "@frontend/views/layouts/mainWithSidebar";
        $this->sidebar = $this->renderPartial('@frontend/views/site/sidebarMenu');
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
}
