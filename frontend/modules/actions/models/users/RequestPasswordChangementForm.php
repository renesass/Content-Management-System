<?php
	
namespace frontend\modules\actions\models\users;

use Yii;
use yii\base\Model;
use common\models\User;

class RequestPasswordChangementForm extends Model
{
    public $email;

    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\common\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => ''
            ],
        ];
    }
    
    public function attributeLabels()
    {
		return [
			'email' => 'E-Mail-Adresse'
		];
    }
}
