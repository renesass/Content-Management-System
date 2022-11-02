<?php

namespace backend\modules\settings\modules\plugins\models;

use Yii;

class Plugin extends \rs\plugins\Plugin
{
    public function rules()
    {
        return [
            [['name', 'label', 'source', 'table_name'], 'required'],
            [['name', 'label', 'table_name'], 'string', 'max' => 64],
            [['name', 'table_name'], 'unique'],
            ['name', 'reserved'],
        ];
    }
    
    public function reserved($attribute, $params, $validator)
    {
        if (in_array($this->name, $this->reservedNames)) {
            $this->addError($attribute, 'Dieser Name ist für ein Hauptmodul belegt.');
        }
    }

    public function attributeLabels()
    {
        return [
            'label' => 'Bezeichnung',
            'name' => 'Name',
            'table_name' => 'Tabellenname',
        ];
    }
    
    public function attributeHints()
    {
	    return [
		    'table_name' => 'Im Normalfall Singular vom Name.',
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
