<?php

namespace backend\rbac;

use Yii;
use rs\rbac\Rule;

/**
 * Checks if user group matches
 */
class AdminRule extends Rule
{
    public $name = 'admin';

    public function execute($user, $item, $params)
    {
	    if (!Yii::$app->user->isGuest) {
		    $user = Yii::$app->user;
		    if (($user->identity->id == 1) || $user->can('super-admin')) {
			    return true;
		    } 
        }
        
	    /*
        if (!Yii::$app->user->isGuest) {
            $group = Yii::$app->user->identity->group;
            if ($item->name === 'admin') {
                return $group == 1;
            } elseif ($item->name === 'author') {
                return $group == 1 || $group == 2;
            }
        } */
        return false;
    }
}

?>