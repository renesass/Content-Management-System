<?php

namespace backend\modules\settings\modules\globals\models;

class GlobalGroup extends \rs\db\ActiveRecord
{
	public static function tableName()
    {
        return 'global_group';
    }
    
	public function rules()
    {
        return [
            [['label', 'name'], 'required'],
            [['label', 'name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['field_ids'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label' => 'Bezeichnung',
            'name' => 'Name',
            'field_ids' => 'Felder',
        ];
    }
    
    public function load($data, $formName = null) {
		if (!empty($this->field_ids)) {
			$this->field_ids = explode(", ", $this->field_ids);
		}
		
		return parent::load($data, $formName);
	}
    
	public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
	    
	    $this->label = ucfirst($this->label);
		
		// transform array to imploded string
		if (!empty($fields = $this->field_ids)) {
			$this->field_ids = implode(", ", $fields);
		}
		
	    return true;
	}	
    
    public static function removeField($fieldId) {
        $groups = self::find()->all();
        
        if (empty($groups)) {
            return;
        }
        
        foreach ($groups as $group) {
            $fieldIds = explode(", ", $group->field_ids);
            $key = array_search($fieldId, $fieldIds);
            
            if ($key !== false) {
                $fieldIds[$key] = null;
                $group->field_ids = $fieldIds;
                $group->save();
            }
        }
    }
}