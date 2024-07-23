<?php

namespace app\modules\controllers;


use Yii;
use app\modules\models\pagination\Pagination;
use app\modules\models\form\ProductForm;
use app\modules\models\search\ProductSearch;
use app\modules\models\Product;
use app\modules\https_code;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;

class ProductController extends Controller
{

    public function actionIndex()
    {
        $product = Product::find();

        $pageSize = Yii::$app->request->get('pageSize', 10);
        $search = Yii::$app->request->get('search');
        $filter = Yii::$app->request->get('filter', 'name');

        if ($product) {
            $provider = Pagination::getPagination($product, $pageSize, SORT_ASC, $search, $filter);
            return $this->json(true, ['data' => $provider], 'success', https_code::success_code);
        }
        return $this->json(false, [], 'success', https_code::bad_request_code);
    }

    /**
     * @throws Exception
     */
    public function actionCreate()
    {
        $product = new ProductForm();
        $data = $product->load(Yii::$app->request->post());
        $product->user_id = Yii::$app->user->identity->id;
        $product->uploadFiles($data);
        if($product->validate() && $product->save())
        {
            return $this->json(true, ['data' => $product], https_code::success_code);
        }
        return $this->json(false, $product->getErrors(), "Create product fail", https_code::bad_request_code);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate($id)
    {
        $product = ProductForm::findOne($id);

        if($product == null)
        {
            return $this->json(false, [], "Product not found", https_code::notfound_code);
        }

        $data = $product->load(Yii::$app->request->post());
        $product->user_id = Yii::$app->user->identity->id;
        $product->uploadFiles($data);
        if($product->validate() && $product->save())
        {
            return $this->json(true, ['data' => $product],"Update Product success", https_code::success_code);
        }
        return $this->json(false, $product->getErrors(),"Update Product fails", https_code::bad_request_code);
    }

    /**
     * @throws Exception
     */
    public function actionDelete($id)
    {
        $product = Product::find()->select(['id'])->where(['id' => $id])->one();
        if ($product) {
            $product->status = https_code::status_delete;
            $product->save();
            return $this->json(true, $product, "success", https_code::success_code);
        }
        return $this->json(false, [], "Product not found", https_code::notfound_code);
    }
}
