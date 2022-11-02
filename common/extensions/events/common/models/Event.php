<?php

namespace common\extensions\events\common\models;

use Yii;
use \DateTime;

class Event extends \rs\db\ActiveRecord
{	
    public $date;
    public $time;
    private static $tableName;
    
    public function __construct($tableName = null) { 
        if ($tableName !== null) {
            static::$tableName = $tableName;
        }
    }

    public static function tableName() {
        $tableName = static::$tableName;
        if (empty($tableName)) {
            return Yii::$app->controller->extension->getTableName();
        } else {
            return $tableName;
        } 
    }
    
    public static function release() {
        static::$tableName = null;
    }
    
    public function rules() {
        return [
            [['date', 'time', 'type', 'location'], 'required'],
            [['date'], 'date', 'format' => 'php:d.m.Y'],
            [['time'], 'time', 'format' => 'php:H:i'],
            [['type', 'location', 'hint'], 'string', 'max' => 255],
            [['deregistrations', 'date_time'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'date' => 'Datum',
            'time' => 'Zeit',
            'type' => 'Typ',
            'location' => 'Ort',
            'hint' => 'Hinweis',
        ];
    }
    
    public function getDate() {
	    if (!empty($this->date_time)) {
	    	return date("d.m.Y", DateTime::createFromFormat('Y-m-d H:i:s', $this->date_time)->getTimestamp());
	    }
	    
	    return;
    }
    
    public function getTime() {
	    if (!empty($this->date_time)) {
	    	return date("H:i", DateTime::createFromFormat('Y-m-d H:i:s', $this->date_time)->getTimestamp());
	    }
	    
	    return;
    }
    
    public function load($data, $formName = null) {
	    if (!empty($this->date_time)) {
	    	$this->date = date("d.m.Y", DateTime::createFromFormat('Y-m-d H:i:s', $this->date_time)->getTimestamp());
	    	$this->time = date("H:i", DateTime::createFromFormat('Y-m-d H:i:s', $this->date_time)->getTimestamp());
	    }
	    
		return parent::load($data, $formName);
	}

	public function beforeSave($insert) {
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
        
        if (!empty($this->date) && !empty($this->time)) {
            $date = date("Y-m-d", DateTime::createFromFormat('d.m.Y', $this->date)->getTimestamp());
            $time = date("H:i:s", DateTime::createFromFormat('H:i', $this->time)->getTimestamp());
            
            $this->date_time = $date.' '.$time;
        }

	    return true;
	}
    
    public function getDeregistrations() {
        if ($this->deregistrations !== null) {
            return unserialize($this->deregistrations);
        }
        return [];
    }
    
    /*
    public function setDeregistrations($array) {
        $this->deregistrations = implode(", ", $array);
    }*/
}
