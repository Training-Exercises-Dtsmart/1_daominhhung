<?php

namespace app\modules\controllers;

use app\modules\models\form\SignUp;
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
        if($user)
        {
            $pageSize = Yii::$app->request->get('pageSize', 10);
            $provider = Pagination::getPagination($user,$pageSize, SORT_ASC);
            return $this->json(true, ['data' => $provider], 'success', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, [], 'fails', HTTPS_CODE::BADREQUEST_CODE);
    }

    public function actionLogin(): array
    {
       $model = new SignUp();
        if ($model->load(Yii::$app->request->post(), '') && $model->login())
        {
            return $this->json(true, [], 'Login success', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, [], 'Login false', HTTPS_CODE::BADREQUEST_CODE);
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
            return $this->json(true, ['data' => $user], 'User registered success', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(false, [], 'User registered fails', HTTPS_CODE::SUCCESS_CODE);
    }

    /**
     * @throws Exception
     */
    public function actionLogout($id): array
    {
        if (UserForm::logout($id)) {
            return $this->json(true, [], 'success', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, [], 'logout fails', HTTPS_CODE::BADREQUEST_CODE);
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
        if($user)
        {
            $user->delete();
            return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
        }
        return $this->json(false, [], 'Can not delete', HTTPS_CODE::BADREQUEST_CODE);

    }
}