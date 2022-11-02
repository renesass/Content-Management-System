<?php

namespace backend\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class GeneralSidebarNavigation extends \yii\base\Widget
{
    public $items;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
	    echo '<ul class="sidebar-navigation">';
	    echo '<li class="head">Allgemeines</li>';
	    foreach ($this->items as $name => $label) {
		    $active = (strstr(Yii::$app->controller->getRoute(), '/', true) == $name);
		    
		    if ($active) {
			    $addActiveClass = ' class="active"';
		    } else {
			    $addActiveClass = (string) null;
		    }
		    
		    echo '<li'.$addActiveClass.'><a href="'.Url::to(['/'.$name]).'">'.$label.'</a></li>';
	    }
	    echo '</ul>';
    }
}

?>