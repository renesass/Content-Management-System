<?php

namespace backend\modules\settings\modules\general\models;

class GeneralSettings extends \rs\settings\Settings
{
	public $site_name;
    public $title;
	public $description;
    public $sidebar;
    public $sidebar_template;
	
	public static function section() {
		return 'general';
	}

    public function rules() {
        return [
            [['site_name'], 'required'],
            [['site_name', 'description'], 'string', 'max' => 255],
            [['sidebar'], 'integer'],
            [['sidebar_template', 'title'], 'string', 'max' => 64],
        ];
    }
    
    public function attributeLabels() {
        return [
            'site_name' => 'Seitenname',
            'title' => 'Titel',
            'description' => 'Beschreibung',
            'sidebar' => 'Seitenleiste standardmäßig aktivieren',
            'sidebar_template' => 'Standard Seitenleisten-Template',
        ];
    }
    
    public function attributeHints() {
	    return [
		    'site_name' => 'Name der Webseite, der überall sichtbar ist.',
            'title' => 'Titel der Seite, der auf jeder Seite im oberen Bereich sichtbar ist.',
		    'description' => 'Wird als Kurztext bei Suchmaschinen angezeigt.',
            'sidebar' => 'Die Seitenleiste wird bei Standardfunktionen wie z.B. bei Anmeldung oder Fehlerseiten aktiv.',
	    ];
    }
    
    public function attributes() {
	    return [
	    	'site_name',
            'title',
	    	'description',
            'sidebar',
            'sidebar_template',
	    ];
    }
}
