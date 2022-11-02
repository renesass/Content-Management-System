<?php

namespace backend\modules\settings\modules\users\models;

use Yii;
use rs\base\Model;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class UserSettings extends \rs\settings\Settings
{
	public $public_registration;
	public $verification;
	public $verification_period;
	public $field_ids;
	
	public function section()
	{
		return 'user';
	}

    public function rules()
    {
        return [
            [['verification_period'], 'required'],
            [['public_registration', 'verification', 'verification_period'], 'integer'],
	        [['field_ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'public_registration' => 'Öffentliche Registrierung erlauben (noch nicht implementiert)',
            'verification' => 'E-Mail-Adresse verifizieren (noch nicht implementiert)',
            'verification_period' => 'Verifizierungszeitraum (noch nicht implementiert)',
            'field_ids' => 'Felder',
        ];
    }
    
    public function attributes() {
	    return [
		    'public_registration',
	    	'verification', 
	    	'verification_period', 
	    	'field_ids',
	    ];
    }
    
    public function attributeHints() {
	    return [
		    'verification' => 'Neue E-Mail-Adressen werden nur im System gespeichert, wenn die E-Mail verifiziert wurde. Dieses gilt sowohl bei Registrationen als auch bei Änderungen von E-Mails, jedoch nicht bei Änderungen im Administrationsbereich.', 
	    	'verification_period' => 'Zeit, nachdem der nicht aktivierte Benutzer gelöscht wird. Der Benutzer wird nicht gelöscht, falls er schon einmal aktiviert wurde.', 
	    ];
    }
    
    /**
	  * Will be used in CustomSetting for e.g. in- and explode.
	  */
    public function attributeOptions() {
	    return [
		    'field_ids' => [
			    'array' => true,
		    ]
	    ];
    }
}
