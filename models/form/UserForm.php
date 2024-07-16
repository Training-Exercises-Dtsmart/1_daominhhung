<?php

namespace app\models\form;

use app\models\User;

class UserForm extends User
{


    public function rule()
    {
        return array_merge(parent::rules(), [
            ["name", "required"]
        ]);
    }
}
