<?php
namespace common\models;

use Yii;
use rs\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', 'password'], 'required'],
            ['email', 'email'],
            ['password', 'validatePassword'], // validated by function validatePassword
        ];
    }
    
    public function attributeLabels() {
	    return [
		    'email' => 'E-Mail-Adresse',
		    'password' => 'Passwort',
	    ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Ungültige Kombination von E-Mail-Adresse und Passwort.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
	    $user = $this->getUser();
	    if ($user && $user->isSuspended()) {
            $this->addError('suspended', 'Der Benutzer ist gesperrt.');
			return false;
		}
			
		if ($this->validate()) {
			$user->last_login = time();
			$user->save();
	        
			return Yii::$app->user->login($user, /*$this->rememberMe ? 3600 * 24 * 30 : */ 0);
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
