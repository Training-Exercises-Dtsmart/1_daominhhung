<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use yii\rest\Controller;



class CategoriesController extends Controller
{

    public function actionCategories()
    {
        $categories = Category::find()->all();
        return $categories;
    }

    public function actionCreate()
    {
        $category = new Category();
        $category->load(Yii::$app->request->post(), '');
        $category->save();

        return $category;
    }
}
