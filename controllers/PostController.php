<?php

namespace app\controllers;

use app\models\Post;
use Yii;
use yii\rest\Controller;

class PostController extends Controller
{
    public function actionPost()
    {
        $post = Post::find()->all();
        return $post;
    }

    public function actionCreate()
    {
        $post = new Post();
        $post->load(Yii::$app->request->post(), '');
        $post->save();

        return $post;
    }
}
