<?php
	
namespace common\extensions\events\widgets;

use Yii;
use yii\helpers\Html;
use rs\plugins\Plugin;
use common\extensions\events\common\models\Event;

class Events extends \yii\base\Widget
{
    public $name;

    public function run()
    {
        $extension = Yii::$app->extensions->get($this->name);
        $tableName = $extension->getTableName();
        
        $event = new Event($tableName);
        $events = Event::find()->where(['>=', 'date_time', date('Y-m-d H:i:s')])->orderBy('date_time')->limit(5)->all();
		
		echo '<div class="event-container">';
		foreach ($events as $event) {
			echo '<div class="event">';
			echo $event->type;
			echo '<span>'.$event->getDate().', '.$event->getTime().'</span>';
			echo '<span>'.$event->location.'</span>';
			if ($event->hint) echo '<span>Hinweis: '.$event->hint.'</span>';
			echo '</div>';
		}
		echo '</div>'; 
        
        Event::release();
    }
}

?>