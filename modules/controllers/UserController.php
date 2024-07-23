<?php

namespace app\modules\controllers;

use Yii;
use abhimanyu\sms\components\Sms;
use app\models\LoginForm;
use app\modules\models\form\PasswordResetRequestForm;
use app\modules\models\form\UserForm;
use app\modules\models\User;
use app\modules\https_code;
use app\modules\models\pagination\Pagination;
use yii\db\Exception;


class UserController extends Controller
{
    public function actionIndex(): array
    {
        $user = User::find();
        if($user)
        {
            $pageSize = Yii::$app->request->get('pageSize', 10);
            $search = Yii::$app->request->get('search');
            $provider = Pagination::getPagination($user, $pageSize, SORT_ASC, $search);
            return $this->json(true, ['data' => $provider], 'success', https_code::success_code);
        }
        return $this->json(false, [], 'fails', https_code::bad_request_code);
    }

    public function actionLogin(): array
    {
       $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login())
        {
            $user = $model->getUser();
            if($user->access_token == null)
            {
                $user->access_token = UserForm::getAccessToken();
                $user->save();
            }
            return $this->json(true, [], 'Login success', https_code::success_code);
        }
        return $this->json(false, [], 'Login false', https_code::bad_request_code);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionRegister(): array
    {
        $user = new UserForm();
        $userData = $user->load(Yii::$app->request->post());
        if ($user->register($userData)) {
            return $this->json(true, ['data' => $user], 'User registered success', https_code::bad_request_code);
        }
        return $this->json(false, ['errors' => $user->getErrors()], 'User registered fails', https_code::success_code);
    }

    /**
     * @throws Exception
     */
    public function actionLogout($id): array
    {
        if (UserForm::logout($id)) {
            return $this->json(true, [], 'success', https_code::success_code);
        }
        return $this->json(false, [], 'logout fails', https_code::bad_request_code);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate($id): array
    {
        $user = UserForm::findOne($id);

        if($user == null)
        {
            return $this->json(false, $user->getErrors(), 'User not found', https_code::notfound_code);
        }

        $data = $user->load(Yii::$app->request->post());
        $user->uploadFile($data);
        if ($user->validate() && $user->save()) {

            return $this->json(true, ['data' => $user], 'User updated successfully', https_code::success_code);
        }
        return $this->json(false, $user->getErrors(), 'User not updated', https_code::bad_request_code);
    }

    /**
     * @throws \Throwable
     */
    public function actionDelete($id): array
    {
        $user = User::find()->select('id')->where(['id' => $id])->one();
        if($user)
        {
            $user->status = https_code::status_delete;
            $user->save();
            return $this->json(true, ['data' => $user], 'success', https_code::success_code);
        }
        return $this->json(false, [], 'Can not delete', https_code::bad_request_code);

    }

    public function actionPasswordReset(): array
    {
        $data = Yii::$app->request->post();
        $email = $data['email'] ?? null;

        if (empty($email)) {
            return $this->json(false, [], 'Email is required', https_code::bad_request_code);
        }

        $model = new PasswordResetRequestForm();
        $model->email = $email;

        if ($model->validate()) {
            if ($model->sendEmail()) {
                return $this->json(true, [], 'Check your email for further instructions.', https_code::success_code);
            } else {
                return $this->json(false, [], 'Sorry, we are unable to reset password for the provided email address.', https_code::bad_request_code);
            }
        }
        return $this->json(false, $model->errors, 'Validation failed', https_code::bad_request_code);
    }

//    public function actionSendsms()
//    {
//        $sms = Yii::$app->sms;
//
//        $carrier = 'nexmo';
//        $number = '0359221014';
//        $subject = 'Test Message';
//        $message = 'Hello! This is a test message from Yii2 application.';
//
//        try {
//            $response = $sms->send($carrier, $number, $subject, $message);
//            return "Message sent successfully. Response: " . print_r($response, true);
//        } catch (\Exception $e) {
//            // Xử lý lỗi nếu có
//            return "Error: " . $e->getMessage();
//        }
//    }
    public function actionLocation()
    {
        $districts = Yii::$app->locationComponent->getDistricts();
        return $this->json(true, ['data' => $districts], 'Component get success', https_code::success_code);
    }
}