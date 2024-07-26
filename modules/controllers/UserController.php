<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\form\SignInForm;
use app\modules\models\form\PasswordResetRequestForm;
use app\modules\models\form\UserForm;
use app\modules\models\User;
use app\models\LoginForm;
use app\modules\HttpCode;
use yii\db\Exception;
use app\modules\models\search\Search;

class UserController extends Controller
{
    const STATUS_ACTIVE = 0;
    const STATUS_DELETE = 1;
    public function actionIndex(): array
    {
        $user = User::find();
        $searchModel = new Search();
        $param = Yii::$app->request->queryParams;
        $filter = Yii::$app->request->get('filter', 'username');
        $dataProvider = $searchModel->search($user, $param, $filter);

        if($dataProvider->getModels())
        {
            return $this->json(true, ['data' => $dataProvider], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'fails', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionLogin(): array
    {
       $model = new LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login())
        {
            $user = $model->getUser();
            if($user->access_token == null)
            {
                $user->access_token = SignInForm::getAccessToken();
                $user->save();
            }
            return $this->json(true, ['data' => $user], 'Login success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'Login false', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception`
     * @throws \yii\base\Exception
     */
    public function actionRegister(): array
    {
        $user = new UserForm();
        $userData = $user->load(Yii::$app->request->post());
        if ($user->register($userData)) {
            return $this->json(true, ['data' => $user], 'User registered success', HttpCode::BADREQUESTCODE);
        }
        return $this->json(false, ['errors' => $user->getErrors()], 'User registered fails', HttpCode::SUCCESSCODE);
    }

    /**
     * @throws Exception
     */
    public function actionLogout($id): array
    {
        if (UserForm::logout($id)) {
            return $this->json(true, [], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'logout fails', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate($id): array
    {
        $user = UserForm::findOne($id);

        if($user == null)
        {
            return $this->json(false, $user->getErrors(), 'User not found', HttpCode::NOTFOUNDCODE);
        }

        $data = $user->load(Yii::$app->request->post());
        $user->uploadFile($data);
        if ($user->validate() && $user->save()) {

            return $this->json(true, ['data' => $user], 'User updated successfully', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, $user->getErrors(), 'User not updated', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws \Throwable
     */
    public function actionDelete($id): array
    {
        $user = User::find()->select('id')->where(['id' => $id])->one();
        if($user)
        {
            $user->status = self::STATUS_DELETE;
            $user->save();
            return $this->json(true, ['data' => $user], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'Can not delete', HttpCode::BADREQUESTCODE);

    }

    /**
     * @throws Exception
     */
    public function actionPasswordReset(): array
    {
        $data = Yii::$app->request->post();
        $email = $data['email'] ?? null;

        if (empty($email)) {
            return $this->json(false, [], 'Email is required', HttpCode::BADREQUESTCODE);
        }

        $model = new PasswordResetRequestForm();
        $model->email = $email;

        if ($model->validate()) {
            if ($model->sendEmail()) {
                return $this->json(true, [], 'Check your email for further instructions.', HttpCode::SUCCESSCODE);
            }
        }
        return $this->json(false, $model->errors, 'Validation failed', HttpCode::BADREQUESTCODE);
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
    public function actionLocation(): array
    {
        $districts = Yii::$app->locationComponent->getDistricts();
        return $this->json(true, ['data' => $districts], 'Component get success', HttpCode::SUCCESSCODE);
    }
}