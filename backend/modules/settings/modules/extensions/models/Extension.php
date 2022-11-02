<?php

namespace backend\modules\settings\modules\extensions\models;

use Yii;

class Extension extends \rs\extensions\Extension
{
    public function rules()
    {
        return [
            [['name', 'label', 'table_name', 'source', ], 'required'],
            [['name', 'label', 'table_name', 'source'], 'string', 'max' => 64],
            [['name', 'table_name'], 'unique'],
            ['name', 'isReservedName'],
        ];
    }
    
    public function isReservedName($attribute, $params, $validator)
    {
        if (in_array($this->name, self::RESERVED_NAMES)) {
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

	public function getSources()
	{
		$result = [];
        foreach (glob(Yii::getAlias("@common").'/extensions/*', GLOB_ONLYDIR) as $dir) {
			$result[basename($dir)] = basename($dir);
		} 
		
		return $result;
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
