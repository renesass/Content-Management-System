<?php
	
namespace common\extensions\pictures;
	
use yii\db\Schema;
use yii\helpers\BaseFileHelper;
use common\extensions\pictures\common\models\Picture;

class Migration extends \rs\extensions\Migration
{
	public function up() {
		$this->db->createCommand()->createTable($this->extension->getTableName(), [
			'id' => Schema::TYPE_PK,
			'title' => Schema::TYPE_STRING,
			'description' => Schema::TYPE_TEXT,
			'location' => Schema::TYPE_STRING,
			'date' => Schema::TYPE_DATE,
		])->execute();
		
		// create folder
		$path = Picture::savePath($this->extension);
		if (!file_exists($path)) {
		    BaseFileHelper::createDirectory($path);
		}
	}
	
	public function down() {
		$this->db->createCommand()->dropTable($this->extension->getTableName())->execute();
		
		// remove folder
		$path = Picture::savePath($this->extension);
		if (file_exists($path)) {
		    BaseFileHelper::removeDirectory($path);
		}
	}
}

?>