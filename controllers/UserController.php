<?php

namespace app\controllers;

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

            //Set cứng dữ liệu username va password
            $correctUsername = 'daominhhung';
            $correctPasswordHash  = md5('123123123');

            //Now là lấy ngày hôm nay theo format day-month-year
            $now = (new \DateTime())->format('d-m-Y');

            //Ở đây là so sánh username và password trả về dữ liệu
            if ($inputUsername === $correctUsername && $inputPasswordHashMd5 === $correctPasswordHash) {
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
}
