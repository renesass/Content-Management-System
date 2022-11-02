<?php
	
namespace frontend\modules\intern\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class User extends \common\models\User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'unique'],
            ['email', 'string', 'max' => 255],
            ['email', 'required'],
            ['email', 'email'],
            
            [['first_name', 'last_name'], 'required'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'E-Mail',
            'first_name' => 'Vorname',
            'last_name' => 'Nachname',
        ];
    }
    
    public function attributeHints() 
    {
	    return [
	    ];
    }
    
    public function beforeSave($insert)
	{
	    if (!parent::beforeSave($insert)) {
	        return false;
	    }
	    
	    $this->first_name = ucfirst($this->first_name);
	    $this->last_name = ucfirst($this->last_name);
	    
	    return true;
	}
}