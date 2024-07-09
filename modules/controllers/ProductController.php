<?php

namespace app\modules\controllers;


use Yii;
use app\modules\models\form\ProductForm;
use app\modules\models\search\ProductSearch;
use app\controllers\Controller;
use app\modules\models\Product;
use yii\data\ActiveDataProvider;
use yii\rest\Serializer;
use app\modules\HTTPS_CODE;


class ProductController extends Controller
{
    public function actionIndex()
    {
        Yii::info('This is an informational message', __METHOD__);
        $products = Product::find();

        if(!$products->exists())
        {
            return $this->json(false, [], 'Product not exist', HTTPS_CODE::BADREQUEST_CODE);
        }

        $provider = new ActiveDataProvider([
            'query' => $products,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ]
            ]
        ]);

        $serializer = new Serializer(["collectionEnvelope" => "items"]);
        $data = $serializer->serialize($provider);

        return $this->json(true, $data, 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionSearch()
    {
//        $products = Product::find()->andFilterWhere(['like', 'name', Yii::$app->request->post('param')])->all();
//        if (!$products) {
//            return $this->json(false, [], "Can't search product", Constant_code::NOUTFOUND_CODE);
//        }
        $modelSearch = new ProductSearch();
        $dataProduct = $modelSearch->search(Yii::$app->request->getQueryParams());

        if(!$dataProduct)
        {
            return $this->json(false, [], "Can't search product", HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, $dataProduct, "success", HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionSearchcategories()
    {
        // $products = Product::find()
        //     ->joinWith('categories')
        //     ->andFilterWhere(['like', 'categories.value',  Yii::$app->request->post('param')])
        //     ->all();


        $modelSearch = new ProductSearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->getQueryParams());

        if($dataProvider->getCount() == 0)
        {
            return $this->json(false, [], "Search not found", HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, $dataProvider, "success", HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionCreate()
    {
        $product = new ProductForm();
        $product->load(Yii::$app->request->post(), '');
        if(!$product->validate() || !$product->save())
        {
            return $this->json(false, $product->getErrors(), HTTPS_CODE::NOUTFOUND_CODE);
        }
        return $this->json(true, ['product' => $product], "success", HTTPS_CODE::SUCCESS_CODE);
    }
    
    public function actionUpdate($id)
    {
        $product = ProductForm::findOne($id);
        $product->load(Yii::$app->request->post(), '');
        if(!$product->validate() || !$product->save())
        {
            return $this->json(false, $product->getErrors(),"Can't Update Product", HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $product, "success", HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionDelete($id)
    {
        $product = Product::find()->select(['id'])->where(['id' => $id])->one();

        if (!$product) {
            return $this->json(false, [], "Product not found", HTTPS_CODE::NOUTFOUND_CODE);
        }
        if (!$product->delete()) {
            return $this->json(false, [], "Can't delete product", HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $product, "success", HTTPS_CODE::SUCCESS_CODE);
    }
}
