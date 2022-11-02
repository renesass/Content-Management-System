<?php

namespace backend\modules\settings\modules\users\models;

use Yii;

class Group extends \rs\db\ActiveRecord
{
	public $permissions;
	
    public static function tableName()
    {
        return 'user_group';
    }
    
    public function rules()
    {
        return [
            [['name', 'label'], 'required'],
            [['name', 'label'], 'string', 'max' => 64],
            [['name'], 'unique'],
            
            ['permissions', 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label' => 'Bezeichnung',
            'name' => 'Name',
            'permissions' => 'Rechte',
        ];
    }
    
    public function load($data, $formName = NULL)
    {
	    if (!empty($this->id)) {
		    $authManager = Yii::$app->authManager;
		    
		    $permissions = $authManager->getDirectPermissionsByGroup($this->id);
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
	    
	    $this->label = ucfirst($this->label);
	    
	    return true;
	}
    
    public function afterSave($insert, $changedAttributes) 
    {
		$authManager = Yii::$app->authManager;
		
	    // delete all permissions
		$authManager->removeAssignmentsByGroup($this->id);
		
        // assign permissions
        foreach ($this->permissions as $name => $checked) {
	        if ($checked) {
		        $authManager->assign($authManager->getItem($name), $this->id, true);
		    }
        } 
	    
	    return parent::afterSave($insert, $changedAttributes);
    }
}
