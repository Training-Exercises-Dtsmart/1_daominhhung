<?php

namespace app\modules\controllers;


use Yii;
use app\modules\models\pagination\Pagination;
use app\modules\models\form\ProductForm;
use app\modules\models\search\ProductSearch;
use app\modules\models\Product;
use app\modules\HTTPS_CODE;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;

class ProductController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => ['create', 'update', 'delete'],
                    'roles' => ['admin'],
                ],
                [
                    'allow' => true,
                    'actions' => ['index', 'search', 'searchcategories'],
                    'roles' => ['@'],
                ],
            ],
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        $products = Product::find();

        if(!$products->exists())
        {
            return $this->json(false, [], 'Product not exist', HTTPS_CODE::BADREQUEST_CODE);
        }

        $provider = Pagination::getPagination($products,20, SORT_ASC);
        return $this->json(true, $provider, 'success', HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionSearch()
    {
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
        $modelSearch = new ProductSearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->getQueryParams());

        if($dataProvider->getCount() == 0)
        {
            return $this->json(false, [], "Search not found", HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $dataProvider, "success", HTTPS_CODE::SUCCESS_CODE);
    }

    public function actionCreate()
    {
        $product = new ProductForm();
        $product->load(Yii::$app->request->post(), '');

        if(!$product->validate() || !$product->save())
        {
            return $this->json(false, $product->getErrors(), HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, ['product' => $product], "success", HTTPS_CODE::SUCCESS_CODE);
    }
    
    public function actionUpdate($id)
    {
        $product = ProductForm::findOne($id);
        if(empty($product))
        {
            return $this->json(false, [], "Product not found", HTTPS_CODE::NOUTFOUND_CODE);
        }
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
        if (empty($product)) {
            return $this->json(false, [], "Product not found", HTTPS_CODE::NOUTFOUND_CODE);
        }
        if (!$product->delete()) {
            return $this->json(false, [], "Can't delete product", HTTPS_CODE::BADREQUEST_CODE);
        }
        return $this->json(true, $product, "success", HTTPS_CODE::SUCCESS_CODE);
    }
}
