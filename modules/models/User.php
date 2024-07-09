<?php

namespace app\modules\models;

use app\models\base\User as BaseUser;

class User extends BaseUser
{
    public function fields(): array
    {
        return [
            'id',
            'image',
            'username',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}
