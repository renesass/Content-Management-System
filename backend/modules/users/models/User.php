<?php
	
namespace backend\modules\users\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class User extends \common\models\User
{
	public $activation_manually = true;
    public $password;
    
    public $groups = [];
	public $permissions = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'default'],
			['username', 'unique'],
            ['username', 'string', 'min' => 3, 'max' => 255],

            ['email', 'trim'],
            ['email', 'unique'],
            ['email', 'string', 'max' => 255],
            ['email', 'required'],
            ['email', 'email'],
            
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],

			['activation_manually', 'integer'],

            ['password', 'required', 
            	'when' => function ($model) { 
	            	return $model->activation_manually == 0; 
	            },
            	'whenClient' => "function (attribute, value) {
                	return $('#activation_manually').checked == false;
            	}"
            ],
            ['password', 'string', 'min' => 6,
            	'when' => function ($model) { 
	            	return $model->activation_manually == 0; 
	            },
            	'whenClient' => "function (attribute, value) {
                	return $('#activation_manually').checked == false;
            	}"
            ],

            ['groups', 'safe'],
            ['permissions', 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Benutzername',
            'email' => 'E-Mail',
            'first_name' => 'Vorname',
            'last_name' => 'Nachname',
            'activation_manually' => 'Manuelle Aktivierung',
            'password' => 'Passwort',
        ];
    }
    
    public function attributeHints() 
    {
	    return [
		    'email' => 'Mit dieser E-Mail kann sich der Benutzer anmelden. Außerdem werden interne Nachrichten an diese Adresse versendet.<br>Eine Änderung der E-Mail-Adresse ist ohne Verifizierung sofort gültig.',
		    'activation_manually' => 'Es wird eine E-Mail an den Benutzer mit einem Link zum Setzen des Passworts geschickt. Nachdem der Benutzer sein Passwort gespeichert hat, wird der Benutzer aktiviert.<br>Sollte diese Option deaktiviert sein, so wird der Benutzer sofort aktiviert.',
	    ];
    }
    
    public function load($data, $formName = null)
    {
	    if (!empty($this->id)) {
		    $userGroupManager = Yii::$app->userGroupManager;
		    $authManager = Yii::$app->authManager;
		    
		    $groups = $userGroupManager->getGroupsByUser($this->id);
		    foreach ($groups as $group) {
			    $this->groups[$group->name] = true;
		    }
		    
		    $permissions = $authManager->getDirectPermissionsByUser($this->id);
		    foreach ($permissions as $permission) {
			    $this->permissions[$permission->name] = true;
		    }
		}
	    
		return parent::load($data, $formName);
    }
    
    public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
	    
	    if (empty($this->id)) {
		    // init the user
		    $this->init();
		    
		    // set status
			if (!($this->activation_manually)) {
			    $this->setPassword($this->password);
			    $this->setActive();
		    } else {
			    $this->setPending();
		    }
	    }
	    
	    $this->first_name = ucfirst($this->first_name);
	    $this->last_name = ucfirst($this->last_name);
	    
	    return true;
	}
	
	public function afterSave($insert, $changedAttributes)
	{
		$userGroupManager = Yii::$app->userGroupManager;
        $authManager = Yii::$app->authManager;
		
		// delete all assignments from the user
		$userGroupManager->removeAssignmentsByUser($this->id);
		$authManager->removeAssignmentsByUser($this->id);
		
		// assign user groups
	    foreach ($this->groups as $name => $checked) {
	        if ($checked) {
		        $userGroupManager->assign($userGroupManager->getGroup($name), $this->id);
		    }
        } 
        
        // assign permissions
        foreach ($this->permissions as $name => $checked) {
	        if ($checked) {
		        $authManager->assign($authManager->getItem($name), $this->id);
		    }
        }
		
		return parent::afterSave($insert, $changedAttributes);
	}
}