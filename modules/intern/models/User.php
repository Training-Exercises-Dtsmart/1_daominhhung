<?php

namespace app\modules\intern\models;

use app\models\base\User as BaseUser;
use Yii;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey(): ?string
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->access_token === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public static function isPasswordResetTokenValid($token): bool
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function formName(): string
    {
        return '';
    }


    public function fields(): array
    {
        return [
            'id',
            'image',
            'username',
            'access_token',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }
}
