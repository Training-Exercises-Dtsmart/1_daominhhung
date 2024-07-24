<?php

namespace app\modules\models\form;

use Yii;
use app\modules\https_code;
use app\models\OrderDetail;
use app\modules\models\Product;

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
        if (isset($orderData['product_id']) && isset($orderData['quantity']))
        {
            $productIds = explode(',', $orderData['product_id']);
            $quantities = explode(',', $orderData['quantity']);

//            if (count($productIds) !== count($quantities)) {
//                return false;
//            }

            foreach ($productIds as $index => $productId)
            {
                $quantity = $quantities[$index];
                $orderDetail = new OrderDetailForm();
                $orderDetail->order_id = $this->order_id;
                $orderDetail->product_id = $productId;

                $product = Product::findOne($productId);
                if ($product) {
                    $orderDetail->price = $product->price;
                } else {
                    return false;
                }

                $orderDetail->quantity = $quantity;
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