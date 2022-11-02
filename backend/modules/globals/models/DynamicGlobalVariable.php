<?php

namespace backend\modules\globals\models;

/**
  * Manage all fields.
  */
class DynamicGlobalVariable extends \rs\db\DynamicRecord
{
	// where are the field values saved
	public static $model = '\backend\modules\globals\models\GlobalVariable'; // must be active record
	
	// select just a specific part in $table instead of the whole $table
	public static $subAreaColumn = 'group_id'; // write null if not using
	
	// this message is displayed when no field is selected
	public static $noFieldsMessage = 'Es wurden noch keine Felder dieser Gruppe hinzugefügt.';
}
