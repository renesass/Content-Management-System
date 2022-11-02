<?php

namespace frontend\modules\intern;

class Intern extends \yii\base\Module
{
    public $controllerNamespace = 'frontend\modules\intern\controllers';
    
    public function init()
    {
        parent::init();
        
        $this->setModules(
            ['events' => ['class' => 'common\plugins\events\frontend\Events']]
        );
    }
}
