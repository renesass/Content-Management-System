<?php

namespace backend\modules\pages\models;

class Page extends \rs\db\ActiveRecord
{
	public static function tableName()
    {
        return 'page';
    }
    
	public function rules()
    {
        return [
            [['label'], 'required'],
            [['label'], 'string', 'max' => 255],
            [['text'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label' => 'Bezeichnung',
            'text' => 'Text',
        ];
    }
    
    public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
	    
	    $this->label = ucfirst($this->label);
		
	    return true;
	}	
}