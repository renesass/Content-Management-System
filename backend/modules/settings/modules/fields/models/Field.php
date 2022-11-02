<?php

namespace backend\modules\settings\modules\fields\models;

use Yii;
use yii\helpers\ArrayHelper;

class Field extends \rs\db\ActiveRecord
{	
	public $types; // array of models
	
    public static function tableName()
    {
        return 'field';
    }
    
    public function rules()
    {
        return [
            [['group_id', 'name', 'label', 'type'], 'required'],
            [['group_id'], 'integer'],
            [['hint'], 'string'],
            [['name'], 'unique'],
            [['name', 'label', 'type'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'group_id' => 'Gruppe',
            'label' => 'Bezeichnung',
            'name' => 'Name',
            'hint' => 'Beschreibung',
            'type' => 'Typ',
        ];
    }
    
    public function attributeHints() 
    {
		return [
			'name' => 'Auf diesen Namen wird in Layouts verwiesen.',
		];
	}
	
	public function load($data, $formName = null) {
		if (!empty($this->types[$this->type]->attributes)) {
			$this->types[$this->type]->attributes = unserialize($this->type_details);
		}
		
		return parent::load($data, $formName);
	}

	public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
	    
	    $this->label = ucfirst($this->label);
	    
	    // get all attributes of the selected type
	    // put them in type_details and serialize it
	    $type = $this->types[$this->type] ?? null;
	    
	    // if there is no type without attributes
	    if (empty($type)) {
		    $this->type_details = (string) null;
		    return true;
	    } 
	    // if there is a type and it's valid
	    else if ($type->validate()) {
		    // write all data in type_details
	    	$type_details = [];
	    	foreach ($type->attributes() as $attribute) {
		    	$type_details[$attribute] = $type->$attribute;
	    	} 
	    	
	    	$this->type_details = serialize($type_details);
	    	return true;
	    } 

	    return false;
	}
}
