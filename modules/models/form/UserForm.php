<?php
namespace app\modules\models\form;

use app\models\User;
class UserForm extends User
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [["username", 'password'], "required"],
            ['password', 'string', 'min' => 6],
        ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->password !== null) {
                $this->password = md5($this->password);
            }
            return true;
        }
        return false;
    }
}