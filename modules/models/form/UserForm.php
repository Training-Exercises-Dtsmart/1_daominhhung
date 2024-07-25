<?php
namespace app\modules\models\form;

use app\modules\https_code;
use Yii;
use app\modules\models\User;
use yii\base\Exception;
use yii\web\UploadedFile;

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
        $this->load($userData, '');

        $uploadedImage = $this->uploadFile($userData);
        if ($uploadedImage) {
            $this->image = $uploadedImage;
        }
        if (!$this->validate() || !$this->save()) {
            return false;
        }
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->access_token = self::getAccessToken();
        $this->status = self::statusActive;
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

    public function uploadFile($data)
    {
        $avatarFile = UploadedFile::getInstanceByName('image');
        if ($avatarFile !== null) {
            $oldImage = $this->image;

            $uploadPath = Yii::getAlias('@app/web/assets/images/user/');
            $filename = uniqid() . '.' . $avatarFile->extension;
            $filePath = $uploadPath . $filename;

            if ($avatarFile->saveAs($filePath)) {
                $this->image = $filename;
                if ($oldImage && file_exists($uploadPath . $oldImage)) {
                    unlink($uploadPath . $oldImage);
                }
                return $filename;
            } else {
                return false;
            }
        }
        return false;
    }
}