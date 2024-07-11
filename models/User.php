<?php

namespace app\models;

use Yii;
use \app\models\base\User as BaseUser;

class User extends BaseUser
{
    public function formName(): string
    {
        return '';
    }
}
