<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\form\UserForm;
use app\modules\models\User;
use app\modules\HTTPS_CODE;
use app\modules\models\pagination\Pagination;
use yii\filters\auth\HttpBearerAuth;

class UserController extends Controller
{

    public function actionIndex()
    {
        $user = User::find();
        if(empty($user))
        {
            return $this->json(false, [], 'User not found', HTTPS_CODE::NOUTFOUND_CODE);
        }
        $provider = Pagination::getPagination($user,10, SORT_ASC);
        return $this->json(true, ['data' => $provider], 'success', HTTPS_CODE::SUCCESS_CODE);
    }
    public function actionLogin()
    {
        $username = Yii::$app->getRequest()->post('username');
        $password = Yii::$app->getRequest()->post('password');
        if (!$username || !$password) {
            return $this->json(false, [], 'Missing required parameters: username, password', HTTPS_CODE::BADREQUEST_CODE);
        }
        $user = UserForm::findOne(['username' => $username]);
        if (!$user) {
            return $this->json(false, [], 'User not found or incorrect password', HTTPS_CODE::NOUTFOUND_CODE);
        }
        if (!$user->validatePassword($password, $user->password)) {
            return $this->json(false, [], 'Incorrect password', HTTPS_CODE::BADREQUEST_CODE);
        }
        if (empty($user->access_token)) {
            $user->access_token = Yii::$app->security->generateRandomString();
            $user->save();
        }
        return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
    }
    public function actionRegister()
    {
        $user = new UserForm();
        $user->load(Yii::$app->request->post(), '');
        if(!$user->validate() || !$user->save())
        {
            return $this->json(false, $user->getErrors(), 'User not saved', HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, ['data' => $user], 'success', HTTPS_CODE::SUCCESS_CODE);
    }
    public function actionUpdate($id)
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
    public function actionDelete($id)
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