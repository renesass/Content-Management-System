<?php
	
namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use rs\plugins\Plugin;
use common\models\User;
use \DateTime;

class NextBirthdays extends \yii\base\Widget
{
    public $items;

    public function run()
    {
        $users = User::find()->all();
        
        $list = [];
        $currentMonth = date('m');
        $currentDay = date('d');
        $currentDate = '1'.$currentMonth.$currentDay;
        
		foreach ($users as $user) {
            $birthday = (isset($user->profile->birthday)) ? $user->profile->birthday : false;
            if (!$birthday) continue;
            
            $userMonth = date("m", DateTime::createFromFormat('Y-m-d', $birthday)->getTimestamp());
            $userDay = date("d", DateTime::createFromFormat('Y-m-d', $birthday)->getTimestamp());
            $userDate = '1'.$userMonth.$userDay;
            
            
            if ($userDate < $currentDate) {
                $userDate = '1'.$userDate;
            } 
            
            $list[$userDate][] = $user;
		}
        ksort($list);
        
        $count = 0;
        echo '<ul class="list">';
        foreach ($list as $users) {
		    foreach ($users as $user) {
			    if ($count > ($this->items-1)) {
				    break;
			    }
	            
	            $date = date("d.m.Y", DateTime::createFromFormat('Y-m-d', $user->profile->birthday)->getTimestamp());
	            $daymonth = date("d.m", DateTime::createFromFormat('Y-m-d', $user->profile->birthday)->getTimestamp());
	
	            if ($daymonth === date("d.m")) {
	                $date = "Heute";
	            }
	            
	            echo '<li>'.$user->first_name.' '.$user->last_name.'<br><span>'.$date.'</span></li>';
	            
	            $count++;
	        }
        }
        echo '</ul>'; 
    }
}

?>