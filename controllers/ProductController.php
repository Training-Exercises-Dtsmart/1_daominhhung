<?php

namespace app\controllers;

use app\models\form\ProductForm;
use Yii;
use yii\rest\Controller;
use app\models\Product;

class ProductController extends Controller
{
    public function actionProducts()
    {
      $products = Product::find()->all();

      return $products;
    }

    public function actionCreate()
    {
      $product = new ProductForm();

      $product->load(Yii::$app->request->post(), '');
      $product->save();

      return $product;
    }
}
