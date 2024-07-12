<?php

namespace app\modules\models;

use app\models\base\User as BaseUser;
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

    public function getAuthKey()
    {
        return $this->access_token;
    }

    public function validateAuthKey($authKey)
    {
        return $this->access_token === $authKey;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
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
