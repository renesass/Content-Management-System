<?php
	
namespace backend\modules\users\models;

/**
  * Manage all fields.
  */
class DynamicUserProfile extends \rs\db\DynamicRecord
{
	// where are the field values saved
	public static $model = '\backend\modules\users\models\UserProfile'; // must be active record
	
	// select just a specific part in $table instead of the whole $table
	public static $subAreaColumn = 'user_id'; // write null if not using

	// this message is displayed when no field is selected
	public static $noFieldsMessage = '';
	
	public function formName() 
	{
		return 'Profile';
	}
}
