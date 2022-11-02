<?php

namespace backend\modules\globals\models;

class GlobalVariable extends \rs\db\ActiveRecord
{
    public static function tableName()
    {
        return 'global';
    }
}
