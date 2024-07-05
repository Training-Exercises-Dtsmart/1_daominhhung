<?php

namespace app\modules\controllers;


use Yii;
use app\controllers\Controller;
use app\modules\models\Product;
use yii\data\ActiveDataProvider;
use yii\rest\Serializer;

class ProductController extends Controller
{
    public function actionView()
    {
        $products = Product::find();

        $provider = new ActiveDataProvider([
            'query' => $products,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ]
        ]);

        $serializer = new Serializer(["collectionEnvelope" => "items"]);
        $data = $serializer->serialize($provider);

        return $this->json(true, $data, 'Success');
    }

    public function actionSearch()
    {
        $products = Product::find()->andFilterWhere(['like', 'name', Yii::$app->request->post('param')])->all();
        if (!$products) {
            return $this->json(false, [], "Can't search product", 400);
        }

        return $this->json(true, $products, "Success");
    }

    public function actionSearchcategories()
    {
        // $products = Product::find()
        //     ->joinWith('categories')
        //     ->andFilterWhere(['like', 'categories.value',  Yii::$app->request->post('param')])
        //     ->all();


        $product = Product::find()
            ->joinWith("categories")
            ->andFilterWhere(["LIKE", "categories.value", Yii::$app->request->getQueryParam('categories_value')])
            ->all();

        return $this->json(true, $product, "Success");
    }

    public function actionCreate()
    {
        $product = new Product();

        $product->load(Yii::$app->request->post(), '');

        if (!$product->validate() || !$product->save()) {
            return $this->json(false, [
                "errors" => $product->getErrors()
            ], "Can't create product", 400);
        }

        return $this->json(true, $product, "Success");
    }
    public function actionUpdate($id)
    {
        $product = Product::findOne($id);
        $product->load(Yii::$app->request->post(), '');

        if (!$product->validate() || !$product->save()) {
            return $this->json(false, [
                "errors" => $product->getErrors()
            ], "Can't update product", 400);
        } else {
            return $this->json(true, $product, "Success");
        }
    }

    public function actionDelete($id)
    {
        $product = Product::find()->select(['id'])->where(['id' => $id])->one();

        if (!$product) {
            return $this->json(false, [], "Product not found");
        }
        if (!$product->delete()) {
            return $this->json(false, [], "Can't delete product", 400);
        }

        return $this->json(true, $product, "Success");
    }
}
