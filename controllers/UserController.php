<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\form\UserForm;

class UserController extends Controller
{
    public function actionLogin()
    {
        // Post FormData
        $formData = Yii::$app->request->post();

        //Check Input
        if (isset($formData['username']) && isset($formData['password'])) {
            //Input Username , Password
            $inputUsername = $formData['username'];
            $inputPassword = $formData['password'];

            //Tạo Validate Password , strlen kiểm tra độ dài PHP dưới 8
            if (strlen($inputPassword) < 8) {
                return $this->json(false, error(), 'Password phải có ít nhất 8 ký tự');
            }
            //Gán md5 cho password
            $inputPasswordHashMd5 = md5($inputPassword);
            $user = User::find()->all();
            foreach ($user as $usres) {
                $dataUsername = $usres->username;
                $dataPassword = $usres->password;
            }
            //Ở đây là so sánh username và password trả về dữ liệu
            if ($inputUsername === $dataUsername && $inputPasswordHashMd5 === $dataPassword) {
                return $this->json(true, $user, 'success');
            } else {
                return $this->json(false, $user->error, 'error');
            }
        }
        return $this->json(false, error(), 'Thiếu thông tin đăng nhập');
    }
    public function actionRegister()
    {
        $user = new UserForm();
        $user->load(Yii::$app->request->post(), '');
        $user->save();

        return $user;
    }
    public function actionGet()
    {
        $user = User::find()->all();
        return $user;
    }

    public function actionShow($id)
    {
        $user = User::findOne($id);
        if(!$user)
        {
            return $this->json(false, error(), 'User not found');
        }
        return $this->json(true, $user, 'success');
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if(!$user)
        {
            return  $this->json(false, error(), 'error');
        } else {
            $user->load(Yii::$app->request->post(), '');
            $user->update();
            return $this->json(true, $user, 'success');
        }
    }

    public function actionDelete($id)
    {
        $user = User::find()->select('id')->where(['id' => $id])->one();
        dd($user);die;

        if (!$user) {
            return $this->json(false, error(), 'User not found');
        } else {
            $user->delete();
            return $this->json(true, $user, 'success');
        }
    }
}
