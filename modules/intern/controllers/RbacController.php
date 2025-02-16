<?php

namespace app\modules\intern\controllers;

use Yii;
use yii\base\Exception;

class RbacController extends Controller
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $createPost = $auth->createPermission('create');
        $createPost->description = 'Create';
        $auth->add($createPost);$auth = Yii::$app->authManager;
        $auth->removeAll();

        // add "createProduct" permission
        $createPost = $auth->createPermission('create');
        $createPost->description = 'Create';
        $auth->add($createPost);

        // add "updateProduct" permission
        $updatePost = $auth->createPermission('update');
        $updatePost->description = 'Update';
        $auth->add($updatePost);

        // add "author" role and give this role the "createProduct" permission
        $author = $auth->createRole('author');
        $auth->add($author);
        $auth->addChild($author, $createPost);

        // add "admin" role and give this role the "updateProduct" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $updatePost);
        $auth->addChild($admin, $author);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($author, 2);
        $auth->assign($admin, 1);
    }
}