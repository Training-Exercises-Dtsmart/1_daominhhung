<?php

namespace app\controllers;

use app\models\form\UserForm;
use app\models\User;
use Yii;
use yii\rest\Controller;

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
                return [
                    'status' => 'false',
                    'message' => 'Password phải có ít nhất 8 ký tự',
                ];
            }
            //Gán md5 cho password
            $inputPasswordHashMd5 = md5($inputPassword);

            $user = User::find()->all();
            foreach ($user as $usres) {
                $dataUsername = $usres->username;
                $dataPassword = $usres->password;
            }

            //Now là lấy ngày hôm nay theo format day-month-year
            $now = (new \DateTime())->format('d-m-Y');

            //Ở đây là so sánh username và password trả về dữ liệu
            if ($inputUsername === $dataUsername && $inputPasswordHashMd5 === $dataPassword) {
                return [
                    'status' => 'true',
                    'data' => [
                        'now' => $now,
                    ],
                    'message' => 'success'
                ];
            } else {
                return [
                    'status' => 'false',
                    'data' => [
                        'now' => $now,
                    ],
                    'message' => 'error'
                ];
            }
        } else {
            return [
                'status' => 'false',
                'message' => 'Thiếu thông tin đăng nhập',
            ];
        }
    }
    public function actionRegister()
    {
        $user = new UserForm();
        $user->load(Yii::$app->request->post());
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
        return $user;
    }

    public function actionUpdate($id)
    {
        $user = User::findOne($id);
        if($user === NULL) 
        {
            return [
                'status' => 'false',
                'message' => 'error'
            ];
        } else {
            $user->load(Yii::$app->request->post(), '');
            $user->update();
            return $user;
        }
    }

    public function actionDelete($id)
    {
        $user = User::findOne($id);
        $now = (new \DateTime())->format('d-m-Y');

        if ($user === NULL) {
            return [
                'status' => 'false',
                'data' => [
                    'now' => $now,
                ],
                'message' => 'error'
            ];
        } else {
            $user->delete();
            return [
                'status' => 'true',
                'data' => [
                    'now' => $now,
                ],
                'message' => 'success'
            ];
        }
    }
}
