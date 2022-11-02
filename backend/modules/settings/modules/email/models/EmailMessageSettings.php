<?php
	
namespace backend\modules\settings\modules\email\models;

use Yii;

class EmailMessageSettings extends \rs\settings\Settings
{
	public $active_user_activation_subject;
	public $active_user_activation_message;
	public $passive_user_activation_subject;
	public $passive_user_activation_message;
	public $email_verification_subject;
	public $email_verification_message;
	public $password_changement_subject;
	public $password_changement_message;
	
	public function section() 
	{
		return 'email_message';
	}
	
    public function rules()
    {
        return [
	        [['active_user_activation_subject', 'active_user_activation_message', 'passive_user_activation_subject', 'passive_user_activation_message', 'email_verification_message', 'email_verification_subject', 'password_changement_subject', 'password_changement_message'], 'required'],
            [['active_user_activation_subject', 'passive_user_activation_subject', 'email_verification_subject', 'password_changement_subject'], 'string', 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
	        'active_user_activation_subject' => 'Betreff',
	        'active_user_activation_message' => 'Nachricht',
	        'passive_user_activation_subject' => 'Betreff',
	        'passive_user_activation_message' => 'Nachricht',
	        'email_verification_subject' => 'Betreff',
	        'email_verification_message' => 'Nachricht',
	        'password_changement_subject' => 'Betreff',
	        'password_changement_message' => 'Nachricht',
        ];
    }
    
    public function attributes() {
	    return [
		    'active_user_activation_subject',
		    'active_user_activation_message',
		    
		    'passive_user_activation_subject',
		    'passive_user_activation_message',
		    
		    'email_verification_subject',
		    'email_verification_message',
		    
		    'password_changement_subject',
		    'password_changement_message',
		];
    }
}
