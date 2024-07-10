<?php
namespace app\modules\models\form;

use app\models\User;
class UserForm extends User
{
    public $username;
    public $password;

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [["username", 'password'], "required"],
            ['username', 'string', 'min' => 3, 'max' => 50],
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