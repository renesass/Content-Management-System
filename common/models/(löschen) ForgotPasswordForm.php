<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ForgotPasswordFormblub extends Model
{
    public $email;
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required'],
            // password is validated by validatePassword()
            ['email', 'email'],
        ];
    }
    
    public function attributeLabels() {
	    return [
		    'email' => 'E-Mail-Adresse',
	    ];
    }
	
	public function sendMail() 
	{
		$user = $this->getUser();
		if (!empty($user) && (!$user->isSuspended()) && $user->isActivated()) {
			return $user->sendResetPasswordMail();
		}
		
		return false;
	}
	
    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
