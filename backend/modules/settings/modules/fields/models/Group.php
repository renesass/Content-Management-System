<?php

namespace backend\modules\settings\modules\fields\models;

use Yii;

class Group extends \rs\db\ActiveRecord
{
    public static function tableName()
    {
        return 'field_group';
    }

    public function rules()
    {
        return [
            [['label'], 'required'],
            [['label'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'label' => 'Bezeichnung',
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
