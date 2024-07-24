<?php

namespace app\modules\models\form;

use app\modules\https_code;
use Yii;
use app\models\OrderDetail;

class OrderDetailForm extends OrderDetail
{

    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['order_id', 'product_id'], 'required'],
        ]);
    }

    public function addOrderDetail($orderData): bool
    {
        if (isset($orderData['product_id']))
        {
            $productIds = explode(',', $orderData['product_id']);
            foreach ($productIds as $productId)
            {
                $orderDetail = new OrderDetailForm();
                $orderDetail->order_id = $this->order_id;
                $orderDetail->product_id = $productId;
                $orderDetail->totalPrice = $orderDetail->product->price;
                $orderDetail->totalQuantity = $orderData['totalQuantity'];
                $orderDetail->payment = https_code::payment_cash;
                $orderDetail->status = https_code::status_pending;

                if (!$orderDetail->validate() || !$orderDetail->save())
                {
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}