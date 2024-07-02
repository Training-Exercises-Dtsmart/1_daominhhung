<?php

namespace app\models;

use Yii;

class User extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'users';
    }
}
