<?php

namespace app\modules\controllers;

use app\models\Order;
use Yii;
use app\modules\models\form\OrderForm;
use app\modules\models\pagination\Pagination;
use app\modules\https_code;


class OrderController extends Controller
{
    public function actionIndex()
    {
        $order = Order::find();

        $pageSize = Yii::$app->request->get('pageSize', 10);
        $search = Yii::$app->request->get('search');
        $filter = Yii::$app->request->get('filter', 'code_order');

        if($order)
        {
            $provider = Pagination::getPagination($order, $pageSize, SORT_ASC, $search, $filter);
            return $this->json(true, ['data' => $provider], 'success', https_code::success_code);
        }
        return $this->json(false, [], 'errors', https_code::bad_request_code);
    }
    public function actionCreate()
    {
        $orderForm = new OrderForm();
        $orderData = Yii::$app->request->post();

        if($orderForm->addOrder($orderData) && $orderForm->save()){
            return $this->json(true, ['data' => $orderForm], 'Create order successfully', https_code::success_code);
        }
        return $this->json(false, ['errors' => $orderForm->getErrors()],'Create order fail', https_code::error_code);
    }
}