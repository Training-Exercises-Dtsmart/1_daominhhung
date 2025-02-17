<?php

namespace app\modules\intern\models\form;

class SignInForm extends UserForm
{

    public function fields(): array
    {
        return [
            'username',
            'access_token'
        ];
    }

    public static function findByUsername($username): ?SignInForm
    {
        return static::findOne(['username' => $username]);
    }
}