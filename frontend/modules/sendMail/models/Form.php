<?php

namespace frontend\modules\sendMail\models;

use Yii;
use yii\base\Model;

class Form extends Model
{
    public $group;
    public $subject;
    public $body;

    public function rules() {
        return [
            [['group', 'subject', 'body'], 'required'],
        ];
    }

    public function attributeLabels() {
        return [
            'group' => 'Empfängergruppe',
            'subject' => 'Betreff',
            'body' => 'Nachricht',
        ];
    }
    
    public function listGroups() {
        $groups = Yii::$app->userGroupManager->getGroups();
        $result = [];
        foreach ($groups as $group) {
            $result[$group->name] = $group->label;
        }
        return $result;
    }

    public function sendEmail() {
        $currentUser = Yii::$app->user->identity;
        $users = Yii::$app->userGroupManager->getUsersByGroup($this->group);
        $userMails = [];
        foreach ($users as $user) {
            $userMails[] = $user->email;
        }

        return Yii::$app->mailer->compose()
            ->setTo($userMails)
            ->setFrom([$currentUser->email => $currentUser->first_name.' '.$currentUser->last_name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
