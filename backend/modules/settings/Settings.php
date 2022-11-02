<?php

namespace backend\modules\settings;

class Settings extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\settings\controllers';
    
    public function init()
    {
        parent::init();

        $this->modules = [
            'general' => [
                'class' => 'backend\modules\settings\modules\general\General',
            ],
            'email' => [
	            'defaultRoute' => 'general',
                'class' => 'backend\modules\settings\modules\email\Email',
            ],
            'users' => [
	            'defaultRoute' => 'general',
                'class' => 'backend\modules\settings\modules\users\Users',
            ],
            'extensions' => [
                'class' => 'backend\modules\settings\modules\extensions\Extensions',
            ],
            'fields' => [
                'class' => 'backend\modules\settings\modules\fields\Fields',
            ],
            'globals' => [
                'class' => 'backend\modules\settings\modules\globals\Globals',
            ],
        ];
    }
}
