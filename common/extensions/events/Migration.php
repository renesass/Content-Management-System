<?php
	
namespace common\extensions\events;
	
use yii\db\Schema;

class Migration extends \rs\extensions\Migration
{
	public function up() {
		$this->db->createCommand()->createTable($this->extension->getTableName(), [
			'id' => Schema::TYPE_PK,
			'date_time' => Schema::TYPE_DATETIME,
			'type' => Schema::TYPE_STRING,
			'location' => Schema::TYPE_STRING,
            'deregistrations' => Schema::TYPE_TEXT,
			'hint' => Schema::TYPE_TEXT,
		])->execute();
	}
	
	public function down() {
		$this->db->createCommand()->dropTable($this->extension->getTableName())->execute();
	}
}

?>