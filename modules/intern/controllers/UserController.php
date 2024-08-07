<?php

namespace app\modules\intern\controllers;

use Yii;
use app\models\LoginForm;
use app\modules\intern\HttpCode;
use app\modules\intern\models\form\PasswordResetRequestForm;
use app\modules\intern\models\form\SignInForm;
use app\modules\intern\models\form\UserForm;
use app\modules\intern\models\search\Search;
use app\modules\intern\models\User;
use app\modules\intern\services\UserService;
use yii\db\Exception;

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
       $data = $model->load(Yii::$app->request->post(), '');
        if ($data && $model->login())
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
            return $this->json(true, ['data' => $user], 'User registered success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, ['errors' => $user->getErrors()], 'User registered fails', HttpCode::BADREQUESTCODE);
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
        $userForm = UserForm::findOne($id);

        if($userForm == null)
        {
            return $this->json(false, $userForm->getErrors(), 'User not found', HttpCode::NOTFOUNDCODE);
        }

        $data = Yii::$app->request->post();
        $userService = new UserService();
        if ($userService->update($userForm, $data)) {
            return $this->json(true, ['data' => $userForm], 'User updated successfully', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, $userForm->getErrors(), 'User not updated', HttpCode::BADREQUESTCODE);
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

    public function actionLocation(): array
    {
        $districts = Yii::$app->locationComponent->getDistricts();
        return $this->json(true, ['data' => $districts], 'Component get success', HttpCode::SUCCESSCODE);
    }
}