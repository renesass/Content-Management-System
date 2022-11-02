<?php

namespace backend\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class PluginSidebarNavigation extends \yii\base\Widget
{
    public $items;

    public function init()
    {
        parent::init();
        
        $this->items = Yii::$app->pluginManager->getNavigationItems();
    }

    public function run()
    {
	    echo '<ul class="sidebar-navigation">';
	    
	    if (!empty($items = $this->items)) {
		    echo '<li class="head">Plugins</li>';
		    foreach ($items as $name => $label) {
			    $active = (strstr(Yii::$app->controller->getRoute(), '/', true) == $name);
			    
			    if ($active) {
				    $addActiveClass = ' class="active"';
			    } else {
				    $addActiveClass = (string) null;
			    }
			    
			    echo '<li'.$addActiveClass.'><a href="'.Url::to(['/'.$name]).'">'.$label.'</a></li>';
		    }
		}
		echo '</ul>';
    }
}

?>