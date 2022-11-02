<?php

namespace frontend\basics\page;

use Yii;
use rs\navigations\NavigationItem;
use backend\modules\pages\models\Page;
use yii\filters\AccessControl;

class Controller extends \rs\web\FrontendController
{
	public function init() {
        parent::init();
        
        $this->setViewPath('@frontend/basics/page/views');
    }
    
    public function behaviors() {
        $allow = Yii::$app->user->hasAccess();
        
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => $allow,
                    ],
                ],
            ],
        ];
    }
    
    public function actionIndex()
    {
        $page = Page::find()->where(['id' => $this->navigationItem->assignment])->one();
        $content = Yii::$app->replacer->replace($page->text); 
        
        return $this->render('index', [
            'content' => $content
        ]);
    }
}
