<?php

namespace app\modules\controllers;

use Yii;
use app\models\Order;
use app\modules\models\form\OrderForm;
use app\modules\HttpCode;
use yii\db\Exception;
use app\modules\models\search\Search;

class OrderController extends Controller
{
    public function actionIndex(): array
    {
        $order = Order::find();
        $searchModel = new Search();
        $param = Yii::$app->request->queryParams;
        $filter = Yii::$app->request->get('filter', 'code_order');
        $dataProvider = $searchModel->search($order, $param, $filter);

        if ($dataProvider->getModels()) {
            return $this->json(true, ['data' => $dataProvider->getModels()], 'success', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, [], 'errors', HttpCode::BADREQUESTCODE);
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionCreate(): array
    {
        $orderForm = new OrderForm();
        $orderData = Yii::$app->request->post();

        if($orderForm->addOrder($orderData) && $orderForm->save()){
            return $this->json(true, ['data' => $orderForm], 'Create order successfully', HttpCode::SUCCESSCODE);
        }
        return $this->json(false, ['errors' => $orderForm->getErrors()],'Create order fail', HttpCode::ERRORCODE);
    }

}