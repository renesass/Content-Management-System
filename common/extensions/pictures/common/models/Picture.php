<?php

namespace common\extensions\pictures\common\models;

use Yii;
use yii\helpers\Url;
use DateTime;

class Picture extends \rs\db\ActiveRecord
{
	public $image;
	
	public static function savePath($extension)
	{
		return Yii::getAlias('@common').'/uploads/extensions/'.$extension->name;
	}
	
	public function getImageUrl($extension)
	{
		return Url::base(true).'/common/uploads/extensions/'.$extension->name.'/'.$this->id.'.jpg';
	}
	
    public static function tableName()
    {
	    return Yii::$app->controller->extension->getTableName();
    }
    
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['image'], 'required', 'on' => 'new'],
            [['title', 'description', 'location'], 'string'],
            [['date'], 'date', 'format' => 'php:d.m.Y'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Titel',
            'description' => 'Beschreibung',
            'location' => 'Ort',
            'date' => 'Datum',
            'image' => 'Bild',
        ];
    }
    
    public function getDate() 
    {
	    if (!empty($this->date)) {
	    	return date("d.m.Y", DateTime::createFromFormat('Y-m-d', $this->date)->getTimestamp());
	    }
	    
	    return;
    }
    
    public function load($data, $formName = null) 
    {
	    if (!empty($this->date)) {
	    	$this->date = date("d.m.Y", DateTime::createFromFormat('Y-m-d', $this->date)->getTimestamp());
	    }
	    
		return parent::load($data, $formName);
	}

	public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
		
		if (!empty($this->date)) {
	    	$this->date = date("Y-m-d", DateTime::createFromFormat('d.m.Y', $this->date)->getTimestamp());
	    }
	    
	    return true;
	}
}
