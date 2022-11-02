<?php

namespace backend\modules\users\models;

class UserProfile extends \rs\db\ActiveRecord
{
    public static function tableName()
    {
        return 'user_profile';
    }
}
