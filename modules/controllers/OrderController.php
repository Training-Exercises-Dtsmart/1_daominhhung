<?php

namespace app\modules\controllers;

use Yii;
use app\modules\models\form\OrderForm;
use app\modules\https_code;

class OrderController extends Controller
{
    public function actionIndex()
    {
    }

    public function actionCreate()
    {
        $orderForm = new OrderForm();
        $orderData = Yii::$app->request->post();

        if($orderForm->addOrder($orderData) && $orderForm->save()){
            return $this->json(true, ['data' => $orderForm], 'Create order successfully', https_code::success_code);
        }
        return $this->json(false, ['errors' => $orderForm->getErrors()], https_code::error_code);
    }
}