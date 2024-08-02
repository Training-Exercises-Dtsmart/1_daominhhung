<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\form\CategoryProductForm;
use app\models\CategoryProduct;
use app\modules\models\search\Search;
use app\modules\HttpCode;
use yii\db\Exception;


class CategoryProductController extends Controller
{
    public function actionIndex(): array
    {
        $category_product = CategoryProduct::find();
        $searchModel = new Search();
        $param = Yii::$app->request->queryParams;
        $filter = Yii::$app->request->get('filter', 'name');
        $dataProvider = $searchModel->search($category_product, $param, $filter);
        if($dataProvider->getModels())
        {
            return $this->json(true, ['data' => $dataProvider], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'fail', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $category_product_form = new CategoryProductForm();
        $category_product_form->load(Yii::$app->request->post(), '');
        $user_id = Yii::$app->user->id;
        $category_product_form->user_id = $user_id;

        if($category_product_form->validate() && $category_product_form->save())
        {
            return $this->json(true, ['data' => $category_product_form], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'fail', HttpCode::BADREQUESTCODE);
    }
}