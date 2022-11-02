<?php
	
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use rs\db\ActiveRecord;
use yii\web\IdentityInterface;
use rs\mail\MessageReplacer;
use rs\fields\Field;
use backend\modules\users\models\UserProfile;

class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_PENDING = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_SUSPENDED = 3;
	
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            ['status', 'default', 'value' => static::STATUS_ACTIVE],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'username' => 'Benutzername',
            'first_name' => 'Vorname',
            'last_name' => 'Nachname',
            'email' => 'E-Mail',
            'created_at' => 'Registriert seit',
        ];
    }
    
    public static function statusLabels()
    {
        return [
            static::STATUS_ACTIVE => 'Aktiv',
            static::STATUS_PENDING => 'Unbestätigt',
            static::STATUS_SUSPENDED => 'Gesperrt',
        ];
    }
    
    public static function statusLabel($status) {
	    if (!isset($status)) return null;
	    return static::statusLabels()[$status];
    }
    
    public function init() 
    {
	    $this->generateAuthKey();
	    $this->generatePasswordToken();
    }
    
    public function setActive() 
    {
		$this->status = static::STATUS_ACTIVE;
		$this->removeActivationToken();
	}
	
	public function setPending() 
	{
		$this->status = static::STATUS_PENDING;
		$this->generateActivationToken();
	}
	
	public function isActive() 
	{
		return ($this->status == static::STATUS_ACTIVE && empty($this->activation_token));
	}
    
	public function isPending() 
	{
		return ($this->status == static::STATUS_PENDING && !empty($this->activation_token));
	}
	
	public function isActivated() 
	{
		return !$this->isPending();
	}
	
	public function isSuspended() 
	{
		return ($this->status == static::STATUS_SUSPENDED);
	}
	
	public function suspend() 
	{
		$this->status = static::STATUS_SUSPENDED;
	    $this->save();
	}
	
	public function unsuspend() 
	{
	    if (!empty($user->verify_token)) {
		    $this->status = static::STATUS_PENDING;
	    } else {
		    $this->status = static::STATUS_ACTIVE;
	    }
		$this->save();
	}

	public function wasPassivelyRegistered() 
	{
		return (!$this->hasPassword() && $this->isPending());
	}
	
	public function wasActivelyRegistered() 
	{
		return ($this->hasPassword() && $this->isPending());
	}
	
	public function hasPassword()
	{
		return (!empty($this->password_hash));
	}
	
	public function hasUnconfirmedEmail() 
	{
		return (!empty($this->new_email) && !empty($this->verification_token));
	}
	
	public function confirmEmail() 
	{
		$this->removeVerificationToken();
	    $this->email = $this->new_email;
		$this->new_email = null;
	}
	
	public function canChangePassword() 
	{
		return (!($this->isSuspended()) && !($this->isPending()) && $this->hasPassword());
	}
	
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }
    
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }
    
    public static function findByPasswordToken($token)
    {
        if (!static::isPasswordTokenValid($token)) {
            return null;
        }
        
        return static::find()
        	->where(['password_token' => $token])
        	->one();
    }

    public static function isPasswordTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        
        return true;
    }
    
    public static function findByActivationToken($token)
    {
        if (!static::isActivationTokenValid($token)) {
            return null;
        }
        
        return static::find()
        	->where(['activation_token' => $token])
        	->one();
    }

    public static function isActivationTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        return true;
    }
    
    public static function findByVerificationToken($token)
    {
        if (!static::isVerificationTokenValid($token)) {
            return null;
        }
        
        return static::find()
        	->where(['verification_token' => $token])
        	->one();
    }

    public static function isVerificationTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        return true;
    }
    
    public function getProfile() {
        if (($profiles = UserProfile::findAll(['user_id' => $this->id])) === null) {
            return null;
        }
        
        $class = new \stdClass();
        foreach ($profiles as $profile) {
            $fieldId = $profile->field_id;
            $field = Field::find()->where(['id' => $fieldId])->one();
            $class->{$field->name} = $profile->value;
        }
        
        return $class;
    } 

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function generatePasswordToken()
    {
        $this->password_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removePasswordToken()
    {
        $this->password_token = null;
    }
    
    public function generateActivationToken()
    {
        $this->activation_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removeActivationToken()
    {
        $this->activation_token = null;
    }
    
    public function generateVerifyToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function removeVerifyToken()
    {
        $this->verification_token = null;
    }
    
    public function sendPassiveUserActivation()
    {
        $manager = (Yii::$app->id == "backend") ? "urlManagerFrontend" : "urlManager";
        
	    if ($this->wasPassivelyRegistered()) {
		    return Yii::$app
	            ->mailer
	            ->compose(
	                ['text' => 'text'],
	                [
	                	'user' => $this,
	                	'label' => 'Benutzer aktivieren',
	                	'link' => Yii::$app->$manager->createAbsoluteUrl(['actions/users/activate', 'token' => $this->activation_token]),
	                	'section' => 'passive_user_activation',
	                ]
	            )
	            ->setFrom([Yii::$app->settingManager->get('email', 'system_address') => Yii::$app->settingManager->get('email', 'system_name')])
	            ->setTo($this->email)
	            ->setSubject(Yii::$app->settingManager->get('email_message', 'passive_user_activation_subject'))
	            ->send();
	    }
	    
	    return false;
    }
    
     public function sendActiveUserActivation()
     {
        $manager = (Yii::$app->id == "backend") ? "urlManagerFrontend" : "urlManager";
         
	    if ($this->wasActivelyRegistered()) {
		    return Yii::$app
	            ->mailer
	            ->compose(
	                ['text' => 'text'],
	                [
	                	'user' => $this,
	                	'label' => 'Benutzer aktivieren',
	                	'link' => Yii::$app->$manager->createAbsoluteUrl(['actions/users/activate', 'token' => $this->activation_token]),
	                	'section' => 'active_user_activation',
	                ]
	            )
	            ->setFrom([Yii::$app->settingManager->get('email', 'system_address') => Yii::$app->settingManager->get('email', 'system_name')])
	            ->setTo($this->email)
	            ->setSubject(Yii::$app->settingManager->get('email_message', 'active_user_activation_subject'))
	            ->send();
	    }
	    
	    return false;
    }
    
    
    public function sendPasswordChangement()
    {
        $manager = (Yii::$app->id == "backend") ? "urlManagerFrontend" : "urlManager";
            
	    if ($this->canChangePassword()) {
		    return Yii::$app
	            ->mailer
	            ->compose(
	                ['text' => 'text'],
	                [
	                	'user' => $this,
	                	'label' => 'Passwort ändern',
	                	'link' => Yii::$app->$manager->createAbsoluteUrl(['actions/users/set-password', 'token' => $this->password_token]),
	                	'section' => 'password_changement',
	                ]
	            )
	            ->setFrom([Yii::$app->settingManager->get('email', 'system_address') => Yii::$app->settingManager->get('email', 'system_name')])
	            ->setTo($this->email)
	            ->setSubject(Yii::$app->settingManager->get('email_message', 'password_changement_subject'))
	            ->send();
	    }
	    
	    return false;
    }
    
    public function sendEmailVerification()
    {
        /*
	    if ($this->hasUnconfirmedEmail()) {
		    return Yii::$app
	            ->mailer
	            ->compose(
	                ['text' => 'text'],
	                [
	                	'user' => $this,
	                	'label' => 'E-Mail-Adresse verifizieren',
	                	'link' => Yii::$app->urlManager->createAbsoluteUrl(['actions/users/verify', 'token' => $this->verification_token]),
	                	'section' => 'email_verification',
	                ]
	            )
	            ->setFrom([Yii::$app->settingManager->get('email', 'system_address') => Yii::$app->settingManager->get('email', 'system_name')])
	            ->setTo($this->email)
	            ->setSubject(Yii::$app->settingManager->get('email_message', 'email_verification_subject'))
	            ->send();
	    } */
	    
	    return false;
    }
}