<?php

namespace common\extensions\events\common\models;

use Yii;
use \DateTime;
use common\models\User;

class EventDeregistration extends \rs\db\ActiveRecord
{	
    public static function tableName()
    {
	    return Yii::$app->controller->extension->getTableName();
    }
    
    public function rules()
    {
        return [
            [['deregistrations'], 'safe'],
        ];
    }
    
    public function getDeregistrations() {
        if ($this->deregistrations !== null) {
            return unserialize($this->deregistrations);
        }
        return [];
    }
    
    public function addDeregistration($userID, $reason = "") {
	    $deregistrations = $this->getDeregistrations();
	    $deregistrations[$userID] = $reason;
	    
	    $this->deregistrations = serialize($deregistrations);
    }
    
    public function removeDeregistration($userID) {
	    $deregistrations = $this->getDeregistrations();
	    unset($deregistrations[$userID]);
	    
	    if (empty($deregistrations)) {
		    $this->deregistrations = Null;
	    } else {
		    $this->deregistrations = serialize($deregistrations);
	    }
    }
    
    public static function listDeregisteredUsers() {
        $events = Event::find()->where(['>=', 'date_time', date('Y-m-d H:i:s')])->orderBy('date_time')->all();
        foreach ($events as $event) {
            echo "<p>";
            if (!empty($event->deregistrations)) {
                echo '<b>'.$event->getDate().', '.$event->getTime().'</b><br>';
                
                $users = [];
                foreach ($event->getDeregistrations() as $userId => $reason) {
                    
                    $user = User::find()->where(['id' => $userId])->one();
                    if (!empty($user)) {
	                    if ($reason == "") {
		                	$users[] = $user->first_name.' '.$user->last_name;
	                    } else {
		                	$users[] = $user->first_name.' '.$user->last_name.' ('.$reason.')';
	                    }
                    }
                }
                
                echo "<i>".implode(", ", $users)."</i>";
            }
            echo "</p>";
        }
    }
}
