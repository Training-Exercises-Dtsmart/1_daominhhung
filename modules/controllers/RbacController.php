<?php

namespace app\modules\controllers;

use Yii;
use app\modules\controllers\Controller;

class RbacController extends Controller
{
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $createPost = $auth->createPermission('create-post');
        $createPost->description = 'Create a post';
        $auth->add($createPost);
    }
}