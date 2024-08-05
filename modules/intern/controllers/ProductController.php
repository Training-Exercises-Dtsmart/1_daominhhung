<?php

namespace app\modules\intern\controllers;


use Yii;
use app\models\Review;
use app\modules\intern\HttpCode;
use app\modules\intern\models\form\ProductForm;
use app\modules\intern\models\Product;
use app\modules\intern\models\search\Search;
use yii\db\Exception;

class ProductController extends Controller
{
    const STATUS_ACTIVE = 0;
    const STATUS_DELETE = 1;
    public function actionIndex(): array
    {
        $product = Product::find();
        $searchModel = new Search();
        $param = Yii::$app->request->queryParams;
        $filter = Yii::$app->request->get('filter', 'name');
        $dataProvider = $searchModel->search($product, $param, $filter);

        if ($dataProvider->getModels()) {
            return $this->json(true, ['data' => $dataProvider->getModels()], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'No data found', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $product = new ProductForm();
        $data = $product->load(Yii::$app->request->post());
        $product->user_id = Yii::$app->user->identity->id;
        $product->uploadFiles($data);
        $product->status = self::STATUS_ACTIVE;

        if($product->validate() && $product->save())
        {
            return $this->json(true, ['data' => $product], HttpCode::SUCCESSCODE);
        }
        return $this->json(false, $product->getErrors(), "Create product fail", HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     */
    public function actionUpdate($id): array
    {
        $product = ProductForm::findOne($id);

        if($product == null)
        {
            return $this->json(false, [], "Product not found", HttpCode::NOTFOUNDCODE);
        }

        $data = $product->load(Yii::$app->request->post());
        $product->user_id = Yii::$app->user->identity->id;
        $product->uploadFiles($data);
        if($product->validate() && $product->save())
        {
            return $this->json(true, ['data' => $product],"Update Product success", HttpCode::SUCCESSCODE);
        }
        return $this->json(false, $product->getErrors(),"Update Product fails", HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     */
    public function actionDelete($id): array
    {
        $product = Product::find()->select(['id'])->where(['id' => $id])->one();
        if ($product) {
            $product->status = self::STATUS_DELETE;
            $product->save();
            return $this->json(true, $product, "success", HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], "Product not found", HttpCode::NOTFOUNDCODE);
    }

    /**
     * @throws Exception
     */
    public function actionReview(): array
    {
        $review = new Review();
        $review->load(Yii::$app->request->post(), '');
        $review->user_id = Yii::$app->user->identity->id;
        $review->status = self::STATUS_ACTIVE;

        if($review->validate() && $review->save())
        {
            return $this->json(true, ['data' => $review], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, $review->getErrors(), "Create product fail", HttpCode::BADREQUESTCODE);
    }
}
