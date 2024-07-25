<?php

namespace app\modules\models\form;

use Yii;
use app\modules\https_code;
use app\models\OrderDetail;
use app\modules\models\Product;
use yii\db\Exception;

class OrderDetailForm extends OrderDetail
{
    const STATUS_PENDING = 1;
    const PAYMENT_CASH = 1;
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            [['order_id', 'product_id'], 'required'],
        ]);
    }

    /**
     * @throws Exception
     */
    public function addOrderDetail($orderData): bool
    {
        if (isset($orderData['product_id']) && isset($orderData['quantity']))
        {
            $productIds = explode(',', $orderData['product_id']);
            $quantities = explode(',', $orderData['quantity']);

            foreach ($productIds as $index => $productId)
            {
                $quantity = $quantities[$index];
                $orderDetail = new OrderDetailForm();
                $orderDetail->order_id = $this->order_id;
                $orderDetail->product_id = $productId;

                $product = Product::findOne($productId);
                if($product)
                {
                    if ($product->stock < $quantity) {
                        return false;
                    }
                    $product->stock -= $quantity;
                    if (!$product->save()) {
                        return false;
                    }
                }
                $product = Product::findOne($productId);
                if ($product) {
                    $orderDetail->price = $product->price;
                }

                $orderDetail->quantity = $quantity;
                $orderDetail->payment = self::PAYMENT_CASH;
                $orderDetail->status = self::STATUS_PENDING;

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