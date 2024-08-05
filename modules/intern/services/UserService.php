<?php

namespace app\modules\intern\services;

use Yii;
use yii\base\Exception;
use yii\web\UploadedFile;
use app\modules\intern\models\form\UserForm;

class UserService
{
    /**
     * @throws Exception
     */
    public function register(UserForm $user, $userData): bool
    {
        $user->load($userData, '');
        $uploadedImage = $this->uploadFile($user, $userData);
        if ($uploadedImage) {
            $user->image = $uploadedImage;
        }
        if (!$user->validate() || !$user->save()) {
            return false;
        }
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
        $user->access_token = UserForm::getAccessToken();
        $user->status = UserForm::statusActive;
        return true;
    }

    /**
     * @throws \yii\db\Exception
     */
    public function update(UserForm $user, $userData): bool
    {
        $user->load($userData, '');
        $uploadedImage = $this->uploadFile($user, $userData);
        if ($uploadedImage) {
            $user->image = $uploadedImage;
            return true;
        }
        if($user->validate() && $user->save())
        {
            return true;
        }
        return false;
    }

    /**
     * @throws \yii\db\Exception
     */
    public static function logout(int $id): bool
    {
        $user = UserForm::findOne($id);
        if ($user) {
            $user->access_token = null;
            return $user->save();
        }
        return false;
    }

    public function uploadFile(UserForm $user, $data)
    {
        $avatarFile = UploadedFile::getInstanceByName('image');
        if ($avatarFile !== null) {
            $oldImage = $user->image;

            $uploadPath = Yii::getAlias('@app/web/assets/images/user/');
            $filename = uniqid() . '.' . $avatarFile->extension;
            $filePath = $uploadPath . $filename;

            if ($avatarFile->saveAs($filePath)) {
                $user->image = $filename;
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
