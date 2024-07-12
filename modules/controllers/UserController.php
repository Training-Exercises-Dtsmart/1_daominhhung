<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\form\UserForm;
use app\modules\models\User;
use app\modules\HTTPS_CODE;
use app\modules\models\pagination\Pagination;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\filters\auth\HttpBearerAuth;

class UserController extends Controller
{
    public function actionIndex(): array
    {
        $user = User::find();
        if(empty($user))
        {
            return $this->json(false, [], 'User not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $provider = Pagination::getPagination($user,10, SORT_ASC);
        return $this->json(true, ['data' => $provider], 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionLogin(): array
    {
        $username = Yii::$app->getRequest()->post('username');
        $password = Yii::$app->getRequest()->post('password');
        if (!$username || !$password) {
            return $this->json(false, [], 'Missing required parameters: username, password', HTTPS_CODE::BADREQUEST_CODE);
        }
        $user = UserForm::login($username, $password);
        if(!$user)
        {
            return $this->json(false, [], 'Login fails', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, ['data' => $user], 'Login success', HTTPS_CODE::SUCCESS_CODE);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionRegister(): array
    {
        $user = new UserForm();
        $userData = Yii::$app->request->post();
        if (!$user->register($userData)) {
            return $this->json(false, ['data' => $user], 'User registered fail', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, ['data' => $user], 'User registered success', HTTPS_CODE::SUCCESS_CODE);
    }

    /**
     * @throws Exception
     */
    public function actionLogout($id): array
    {
        if (!UserForm::logout($id)) {
            return $this->json(false, [], 'User not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, [], 'success', HTTPS_CODE::SUCCESS_CODE);
    }
    public function actionUpdate($id): array
    {
        $user = UserForm::find($id);
        if(empty($user))
        {
            return $this->json(false, [], 'User not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $user->load(Yii::$app->request->post());
        if(!$user->validate() || !$user->save())
        {
            return $this->json(false, $user->getErrors(), 'User not updated', HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    /**
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $user = User::find()->select('id')->where(['id' => $id])->one();
        if(empty($user))
        {
            return $this->json(false, [], 'User not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $user->delete();
        return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
    }
}