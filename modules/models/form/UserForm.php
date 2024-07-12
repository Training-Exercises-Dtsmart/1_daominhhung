<?php
namespace app\modules\models\form;

use Yii;
use app\models\User;
use yii\base\Exception;
use yii\web\UploadedFile;
use yii\helpers\Json;

class UserForm extends User
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['username', 'password'], "required"],
            ['password', 'string', 'min' => 6],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
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
    public static function login($username, $password)
    {
        $user = self::findOne(['username' => $username]);
        if (!$user || !$user->validatePassword($password)) {
            return false;
        }
        $user->access_token = self::getAccessToken();
        if ($user->save()) {
            return $user;
        }
        return false;
    }

    /**
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function register($userData): bool
    {
        $this->load($userData, '');
        if (!$this->validate()) {
            return false;
        }
        $avatarFile = UploadedFile::getInstance($this, 'image');
        if ($avatarFile) {
            $uploadPath = Yii::getAlias('@app/modules/models/upload/');
            $filename = uniqid() . '.' . $avatarFile->extension;
            $filePath = $uploadPath . $filename;
            if (!$avatarFile->saveAs($filePath)) {
                return false;
            }
            $this->image = $filename;
        }
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->access_token = self::getAccessToken();

        if (!$this->save()) {
            return false;
        }
        return true;
    }
    /**
     * @throws \yii\db\Exception
     */
    public static function logout(int $id): bool
    {
        $user = self::findOne($id);
        if ($user) {
            $user->access_token = null;
            return $user->save();
        }
        return false;
    }
}