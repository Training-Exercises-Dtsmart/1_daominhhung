<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;
use app\models\Products;

class ProductController extends Controller
{
    public function actionProducts()
    {
      $products = Products::find()->all();

      return $products;
    }
}
