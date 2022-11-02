<?php

namespace backend\modules\settings\modules\email\models;

use Yii;

class EmailSettings extends \rs\settings\Settings
{
	public $system_address;
	public $system_name;
	
	public function section() 
	{
		return 'email';
	}

    public function rules()
    {
        return [
            [['system_address', 'system_name'], 'required'],
            [['system_address'], 'email'],
            [['system_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'system_address' => 'System-Adresse',
            'system_name' => 'System-Name',
        ];
    }
    
    public function attributeHints()
    {
	    return [
			'system_address' => 'Diese E-Mail-Adresse wird beim Senden von automatisch generierten Nachrichten verwendet.',
            'system_name' => 'Der Name, der beim versendet einer automatisch generierten E-Mail angezeigt wird.',  
	    ];
    }
    
    public function attributes() 
    {
	    return [
	    	'system_address', 
	    	'system_name'
	    ];
    }
}
