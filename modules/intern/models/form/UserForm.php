<?php

namespace app\modules\intern\models\form;

use app\modules\intern\services\UserService;
use app\modules\intern\models\User;
use Yii;
use yii\base\Exception;

class UserForm extends User
{
    const statusActive = 0;

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['username', 'password'], 'required'],
            ['username', 'email'],
            ['password', 'string', 'min' => 6],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 10],
        ]);
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    /**
     * @throws Exception
     */
    public static function getAccessToken(): string
    {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function register($userData): bool
    {
        $userService = new UserService();
        return $userService->register($this, $userData);
    }

    /**
     * @throws \yii\db\Exception
     */
    public static function logout(int $id): bool
    {
        return UserService::logout($id);
    }
}
