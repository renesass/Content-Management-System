<?php

namespace frontend\modules\actions\models\users;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

class SetPasswordForm extends Model
{
	public $password;
	
	private $_user;
	
	public function __construct($user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['password'], 'required'],
            ['password', 'string', 'min' => 6]
        ];
    }

    public function attributeLabels()
    {
        return [
            'password' => 'Passwort',
        ];
    }
    
    public function setPassword()
    {
		Yii::$app->user->logout();
				
        $user = $this->_user;
        
        // set active
        if ($user->wasPassivelyRegistered()) {
	        $user->setActive();
        }
        
        // set password
        $user->setPassword($this->password);
        
        // new token
        $user->generatePasswordToken();

        return $user->save();
    }
}
